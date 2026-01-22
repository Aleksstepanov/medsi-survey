<?php

namespace Drupal\medsi_reports\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

class CompanyDashboardController extends ControllerBase {

  public function page(Request $request): array {
    $token = trim((string) $request->query->get('company_token'));
    if ($token === '') {
      return ['#markup' => '<p>Передай <code>?company_token=...</code></p>'];
    }

    $hr = '/report/hr-summary?company_token=' . rawurlencode($token);
    $medsi = '/report/medsi?webform_submission_value=' . rawurlencode($token);

    return [
      '#type' => 'container',
      'intro' => [
        '#markup' => '<p><b>Company token:</b> <code>' . htmlspecialchars($token) . '</code></p>',
      ],
      'links' => [
        '#theme' => 'item_list',
        '#items' => [
          ['#markup' => '<a href="' . $hr . '">HR отчёт (итоги)</a>'],
          ['#markup' => '<a href="' . $medsi . '">MEDSI отчёт (детально)</a>'],
        ],
      ],
    ];
  }

}
