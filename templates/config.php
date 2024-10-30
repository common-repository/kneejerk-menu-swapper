<div class="postbox maxxer">
    <div class="inside">
        <h2>Menu Configurations</h2>
        <hr>
        <div class="main">
            <form id="kjd-menu-swapper-form" method="POST">
                <table class="form-table">
                    <?php if ( !empty($data['theme_menus']) ) { ?>
                    <thead>
                        <tr>
                            <th>Theme Menu Location</th>
                            <th>Default Menu</th>
                            <th>Swap When Logged In</th>
                            <th>Enable Swap!</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $data['theme_menus'] as $nav_slug => $nav_name ) {
                            $menu_id = $data['menu_locations'][$nav_slug] ?? false;
                            $configured_menu = isset($data['config'][$nav_slug]) ? $data['config'][$nav_slug] : false;
                            $default_menu = $data['menus'][$menu_id]->name ?? 'None Selected';
                        ?>
                        <tr>
                            <th scope="row"><?php echo $nav_name ?> (<?php echo $nav_slug ?>)</th>
                            <td>
                                <?php echo $default_menu ?>
                                <?php if ($menu_id) { ?>
                                [<a href="<?php echo admin_url("nav-menus.php?action=edit&menu=$menu_id") ?>">configure menu</a>]
                                <?php } ?>
                            </td>
                            <td>
                                <select name="<?php echo $nav_slug ?>[swap]">
                                    <option value=''>None</option>
                                    <?php foreach ( $data['menus'] as $menu ) {
                                        $selected = $configured_menu && $configured_menu['swap'] == $menu->slug;
                                        ?>
                                    <option value="<?php echo $menu->slug ?>"<?php echo $selected ? ' selected="selected"' : '' ?>><?php echo $menu->name ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="checkbox" name="<?php echo $nav_slug ?>[enabled]"<?php echo isset($configured_menu['enabled']) && $configured_menu['enabled'] ? ' checked="checked"' : '' ?>>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan=4>
                                <button id="kjd-menu-swapper-submit-btn" class="button button-primary">Save</button>
                                <p id="kjd-menu-swapper-results"></p>
                            </td>
                        </tr>
                    </tbody>
                    <?php } else { ?>
                    <caption>No registered menus found for the current theme</caption>
                    <?php } ?>
                </table>
            </form>
        </div>
    </div>
</div>