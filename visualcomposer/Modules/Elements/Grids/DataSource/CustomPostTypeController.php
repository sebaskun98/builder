<?php

namespace VisualComposer\Modules\Elements\Grids\DataSource;

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\PostsGridSourcePosts;
use VisualComposer\Helpers\PostType;
use VisualComposer\Helpers\Traits\EventsFilters;
use WP_Query;

/**
 * Class CustomPostTypeController
 * @package VisualComposer\Modules\Elements\Grids\DataSource
 */
class CustomPostTypeController extends Container implements Module
{
    use EventsFilters;

    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        /** @see \VisualComposer\Modules\Elements\Grids\DataSource\CustomPostTypeController::queryPosts */
        $this->addFilter('vcv:elements:grids:posts', 'queryPosts');

        /** @see \VisualComposer\Modules\Elements\Grids\DataSource\CustomPostTypeController::addGlobalVariables */
        $this->addFilter('vcv:frontend:extraOutput', 'addGlobalVariables');
        $this->addFilter('vcv:backend:extraOutput', 'addGlobalVariables');
    }

    protected function addGlobalVariables($scripts, $payload)
    {
        /** @see visualcomposer/resources/views/elements/grids/sources/custompostvariables.php */
        $variables = [];
        $variables[] = sprintf('<script>%s</script>', vcview('elements/grids/sources/custompostvariables'));

        return array_merge($scripts, $variables);
    }

    /**
     * @param $posts
     * @param $payload
     * @param \VisualComposer\Helpers\PostType $postTypeHelper
     *
     * @param \VisualComposer\Helpers\PostsGridSourcePosts $postsGridSourcePostsHelper
     *
     * @return array
     */
    protected function queryPosts(
        $posts,
        $payload,
        PostType $postTypeHelper,
        PostsGridSourcePosts $postsGridSourcePostsHelper
    ) {
        global $post;
        if (isset($payload['atts']['source'], $payload['atts']['source']['tag'])
            && $payload['atts']['source']['tag'] === 'postsGridDataSourceCustomPostType'
        ) {
            // Value:
            $value = html_entity_decode($payload['atts']['source']['value']);
            if (strpos($value, 'post_type=&') !== false) {
                $postTypes = $postsGridSourcePostsHelper->getPostTypes();
                $firstPostType = sprintf('post_type=%s&', $postTypes[0]['value']);
                $value = str_replace('post_type=&', $firstPostType, $value);
            }
            $paginationQuery = new WP_Query($value);
            $newPosts = [];
            while ($paginationQuery->have_posts()) {
                $paginationQuery->the_post();
                $newPosts[] = $post;
                wp_reset_postdata();
            }
            $posts = array_merge(
                $posts,
                $newPosts
            );
        }

        return $posts;
    }
}
