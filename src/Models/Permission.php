<?php namespace CleanSoft\Modules\Core\Models;

use CleanSoft\Modules\Core\Models\Contracts\PermissionModelContract;
use CleanSoft\Modules\Core\Models\EloquentBase as BaseModel;

class Permission extends BaseModel implements PermissionModelContract
{
    public $timestamps = false;
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'slug', 'module'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, webed_db_prefix() . 'roles_permissions', 'permission_id', 'role_id');
    }
}
