<?php

namespace Drupal\medsi_reports\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * HR summary report: Recommendation -> Count by company_token.
 */
class HrSummaryController extends ControllerBase {

  public function summary(Request $request): array {
    // Support both query param names:
    // - company_token (clean)
    // - webform_submission_value (your current Views param)
    $token = trim((string) $request->query->get('company_token'));
    if ($token === '') {
      $token = trim((string) $request->query->get('webform_submission_value'));
    }

    if ($token === '') {
      return [
        '#markup' => '<p>Pass token in URL, e.g. <code>?company_token=test123</code></p>',
      ];
    }

    $storage = $this->entityTypeManager()->getStorage('webform_submission');

    // Load all submissions for the webform.
    $ids = $storage->getQuery()
      ->accessCheck(FALSE)
      ->condition('webform_id', 'medsi_survey')
      ->execute();

    if (empty($ids)) {
      return ['#markup' => '<p>No submissions yet.</p>'];
    }

    $counts = [];
    $total = 0;

    // Load in chunks to avoid memory issues.
    $ids = array_values($ids);
    $chunk_size = 200;

    for ($i = 0; $i < count($ids); $i += $chunk_size) {
      $chunk = array_slice($ids, $i, $chunk_size);
      $subs = $storage->loadMultiple($chunk);

      foreach ($subs as $sub) {
        $data = $sub->getData();

        $sub_token = isset($data['company_token']) ? (string) $data['company_token'] : '';
        if ($sub_token !== $token) {
          continue;
        }

        $total++;

        // recommendation can be string (select) or array (checkboxes).
        $rec = $data['recommendation'] ?? null;

        if (is_array($rec)) {
          foreach ($rec as $v) {
            $key = (string) $v;
            if ($key === '') continue;
            $counts[$key] = ($counts[$key] ?? 0) + 1;
          }
        }
        else {
          $key = (string) $rec;
          if ($key === '') {
            $key = '(not set)';
          }
          $counts[$key] = ($counts[$key] ?? 0) + 1;
        }
      }
    }

    if ($total === 0) {
      return [
        '#markup' => '<p>No submissions for token <code>' . htmlspecialchars($token) . '</code>.</p>',
      ];
    }

    $labels = [
      'fluoro' => 'Флюорография',
      'cardio' => 'Кардио (ЭКГ/УЗИ)',
      'respiratory' => 'Дыхательная система',
      'other' => 'Другое',
      '(not set)' => '(не указано)',
   ];

    arsort($counts);

    $rows = [];
    foreach ($counts as $key => $cnt) {
      $title = $labels[$key] ?? $key;
      $rows[] = [$title, $cnt];
    }

    return [
      'summary' => [
        '#markup' => '<p><b>Company token:</b> <code>' . htmlspecialchars($token) . '</code><br><b>Total submissions:</b> ' . $total . '</p>',
      ],
      'table' => [
        '#type' => 'table',
        '#header' => ['Recommendation', 'Count'],
        '#rows' => $rows,
        '#empty' => 'No data',
      ],
    ];
  }

}
