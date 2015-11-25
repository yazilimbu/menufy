<?php

namespace Phpuzem\Menufy\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menufy';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'parent_id', 'link', 'name', 'is_active', 'position'];

    /**
     * Self relation
     */

    public function submenus()
    {
        return $this->hasMany('Phpuzem\Menufy\Http\Model\Menu', 'parent_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->whereIs_active(1);
    }

    public function scopeMainmenu($query)
    {
        return $query->whereParent_id(0);
    }

}
