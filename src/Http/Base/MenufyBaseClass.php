<?php

namespace Phpuzem\Menufy\Http\Base;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Phpuzem\Menufy\Http\Model\Menu;

class MenufyBaseClass extends Controller
{
    protected $name;
    protected $link;
    protected $parent_id = 0;
    protected $is_active = 1;
    protected $position = 1;

    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of link.
     *
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the value of link.
     *
     * @param mixed $link the link
     *
     * @return self
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * Gets the value of parent_id.
     *
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Sets the value of parent_id.
     *
     * @param mixed $parent_id the parent id
     *
     * @return self
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    /**
     * Gets the value of is_active.
     *
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Sets the value of is_active.
     *
     * @param mixed $is_active the is active
     *
     * @return self
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * Gets the value of position.
     *
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the value of position.
     *
     * @param mixed $position the position
     *
     * @return self
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function generate()
    {
        $menus = Menu::Active()->Mainmenu()->orderBy("position")->get();
        echo "<ul>";
        foreach ($menus as $menu):
            echo "<li><a href='pages/" . $menu->link . "'>$menu->name";
            if ($menu->submenus->count()) {
                echo "</a>";
            }
            self::recursive($menu->id);
            echo "</li>";
        endforeach;
        echo "</ul>";
    }
    /**
     * @param int $id
     */
    protected function recursive($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->submenus->count()) {
            echo "<ul>";
            foreach ($menu->submenus as $submenu):
                echo "<li><a href='pages/" . $submenu->link . "'>$submenu->name";
                if ($submenu->submenus->count()) {
                    echo "</a>";
                }
                self::recursive($submenu->id);
                echo "</li>";
            endforeach;
            echo "</ul>";
        }
    }

    protected function create()
    {
        if (empty($this->link)) {
            $this->link = str_slug($this->name);
        }
        Menu::create([
            'parent_id' => $this->parent_id,
            'link' => $this->link,
            'name' => $this->name,
            'position' => $this->position,
            'is_active' => $this->is_active,
        ]);
    }

    public function save()
    {
        if (empty($this->name)) {
            return false;
        } else {
            DB::transaction(function () {
                $this->create();
            });
            return true;
        }
    }

}
