<?php namespace CleanSoft\Modules\Core\Models;

use CleanSoft\Modules\Core\Models\Contracts\RoleModelContract;
use CleanSoft\Modules\Core\Models\EloquentBase as BaseModel;
use CleanSoft\Modules\Core\Users\Models\User;

class Role extends BaseModel implements RoleModelContract
{
    protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'slug', 'created_by', 'updated_by'];

    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, webed_db_prefix() . 'roles_permissions', 'role_id', 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, webed_db_prefix() . 'users_roles', 'role_id', 'user_id');
    }

    /**
     * Setter
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }
}
