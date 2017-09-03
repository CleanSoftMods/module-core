<?php namespace WebEd\Themes\Triangle\Criterias\Filters;

use CleanSoft\Modules\Core\Criterias\AbstractCriteria;
use CleanSoft\Modules\Core\Repositories\AbstractBaseRepository;
use CleanSoft\Modules\Core\Repositories\Contracts\AbstractRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use WebEd\Plugins\Blog\Models\Post;

class SearchPostsCriteria extends AbstractCriteria
{
    protected $keyword;

    protected $groupBy;

    protected $select;

    public function __construct($keyword, array $groupBy, array $select)
    {
        $this->keyword = $keyword;
        $this->groupBy = $groupBy;
        $this->select = $select;
    }

    /**
     * @param Post|Builder $model
     * @param AbstractBaseRepository $repository
     * @return mixed
     */
    public function apply($model, AbstractRepositoryContract $repository)
    {
        return $model
            ->leftJoin('posts_tags', 'posts.id', '=', 'posts_tags.post_id')
            ->leftJoin('blog_tags', 'blog_tags.id', '=', 'posts_tags.tag_id')
            ->where('posts.status', '=', 'activated')
            ->where(function ($query) {
                return $query
                    ->orWhere('posts.title', 'LIKE', '%' . $this->keyword . '%')
                    ->orWhere('posts.slug', 'LIKE', '%' . $this->keyword . '%')
                    ->orWhere('blog_tags.title', 'LIKE', '%' . $this->keyword . '%')
                    ->orWhere('blog_tags.slug', 'LIKE', '%' . $this->keyword . '%');
            })
            ->distinct()
            ->groupBy($this->groupBy)
            ->select($this->select)
            ->orderBy('posts.created_at', 'DESC');
    }
}
