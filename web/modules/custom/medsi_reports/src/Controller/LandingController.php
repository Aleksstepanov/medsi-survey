<?php

namespace Drupal\medsi_reports\Controller;

use Drupal\Core\Controller\ControllerBase;

class LandingController extends ControllerBase {

  public function home(): array {
    $build = [
      '#type' => 'markup',
      '#markup' => '
<div class="medsi-landing">
  <div class="medsi-hero">
    <div class="medsi-hero__content">
      <h1 class="medsi-hero__title">Медицинский опрос сотрудников</h1>
      <p class="medsi-hero__subtitle">
        Онлайн-анкетирование сотрудников для формирования рекомендаций
        и последующего анализа со стороны HR и специалистов МЕДСИ.
      </p>

      <div class="medsi-hero__actions">
        <a class="medsi-btn medsi-btn-secondary" href="/how-it-works">Как пользоваться</a>
        <a class="medsi-btn medsi-btn-primary" href="/webform/medsi_survey">Пройти опрос</a>
      </div>

      <div class="medsi-hero__note">
  <a href="/user/login">Войти</a>
</div>

      <div class="medsi-hero__note">
        <span>Для демо:</span>
        <a href="/company-dashboard?company_token=test123">пример компании test123</a>
      </div>
    </div>
  </div>
</div>
',
      '#cache' => ['max-age' => 0],
    ];

    return $build;
  }

  public function howItWorks(): array {
    return [
      '#type' => 'markup',
      '#markup' => '
<div class="medsi-page">
  <h1>Как пользоваться</h1>

  <ol class="medsi-steps">
    <li><b>HR</b> получает уникальную ссылку компании.</li>
    <li>Сотрудники переходят по ссылке и проходят опрос.</li>
    <li>Система формирует рекомендации по обследованиям.</li>
    <li><b>HR</b> видит агрегированный отчёт, <b>МЕДСИ</b> — детальные данные.</li>
  </ol>

  <div class="medsi-hero__actions">
    <a class="medsi-btn medsi-btn-secondary" href="/">На главную</a>
    <a class="medsi-btn medsi-btn-primary" href="/webform/medsi_survey">Пройти опрос</a>
  </div>
</div>
',
      '#cache' => ['max-age' => 0],
    ];
  }
}
