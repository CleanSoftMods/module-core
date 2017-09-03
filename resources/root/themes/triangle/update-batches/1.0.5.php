<?php
use CleanSoft\Modules\Core\CustomFields\Repositories\Contracts\CustomFieldRepositoryContract;

/**
 * @var \CleanSoft\Modules\Core\CustomFields\Repositories\CustomFieldRepository $customFieldRepo
 */
$customFieldRepo = app(CustomFieldRepositoryContract::class);
$pages = $customFieldRepo->getWhere([
    'use_for' => \CleanSoft\Modules\Core\Pages\Models\Page::class,
], ['id'])->pluck('id')->toArray();
$customFieldRepo->updateMultiple($pages, [
    'use_for' => WEBED_PAGES
]);