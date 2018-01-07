<?php

namespace Drupal\ddd_attendee\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\ddd_attendee\Entity\AttendeeInterface;

/**
 * Class AttendeeController.
 *
 *  Returns responses for Attendee routes.
 */
class AttendeeController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Attendee  revision.
   *
   * @param int $attendee_revision
   *   The Attendee  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($attendee_revision) {
    $attendee = $this->entityManager()->getStorage('attendee')->loadRevision($attendee_revision);
    $view_builder = $this->entityManager()->getViewBuilder('attendee');

    return $view_builder->view($attendee);
  }

  /**
   * Page title callback for a Attendee  revision.
   *
   * @param int $attendee_revision
   *   The Attendee  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($attendee_revision) {
    $attendee = $this->entityManager()->getStorage('attendee')->loadRevision($attendee_revision);
    return $this->t('Revision of %title from %date', ['%title' => $attendee->label(), '%date' => format_date($attendee->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Attendee .
   *
   * @param \Drupal\ddd_attendee\Entity\AttendeeInterface $attendee
   *   A Attendee  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(AttendeeInterface $attendee) {
    $account = $this->currentUser();
    $langcode = $attendee->language()->getId();
    $langname = $attendee->language()->getName();
    $languages = $attendee->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $attendee_storage = $this->entityManager()->getStorage('attendee');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $attendee->label()]) : $this->t('Revisions for %title', ['%title' => $attendee->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all attendee revisions") || $account->hasPermission('administer attendee entities')));
    $delete_permission = (($account->hasPermission("delete all attendee revisions") || $account->hasPermission('administer attendee entities')));

    $rows = [];

    $vids = $attendee_storage->revisionIds($attendee);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\ddd_attendee\AttendeeInterface $revision */
      $revision = $attendee_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $attendee->getRevisionId()) {
          $link = $this->l($date, new Url('entity.attendee.revision', ['attendee' => $attendee->id(), 'attendee_revision' => $vid]));
        }
        else {
          $link = $attendee->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.attendee.translation_revert', ['attendee' => $attendee->id(), 'attendee_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.attendee.revision_revert', ['attendee' => $attendee->id(), 'attendee_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.attendee.revision_delete', ['attendee' => $attendee->id(), 'attendee_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['attendee_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
