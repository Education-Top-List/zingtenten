	<ul>   
        <?php 
            $get_parent_cats = array(
                'parent' => '0', //get top level categories only
            ); 

            $all_categories = get_categories( $get_parent_cats );//get parent categories 

            foreach( $all_categories as $single_category ){
                //for each category, get the ID
                $catID = $single_category->cat_ID;

                echo '<li><a href=" ' . get_category_link( $catID ) . ' ">' . $single_category->name . '</a>'; //category name & link
        
                $get_children_cats = array(
                    'child_of' => $catID //get children of this parent using the catID variable from earlier
                );

                $child_cats = get_categories( $get_children_cats );//get children of parent category
                echo '<ul class="children">';
                    foreach( $child_cats as $child_cat ){
                        //for each child category, get the ID
                        $childID = $child_cat->cat_ID;

                        //for each child category, give us the link and name
                        echo '<a href=" ' . get_category_link( $childID ) . ' ">' . $child_cat->name . '</a>';
                    }
                echo '</ul></li>';
            } //end of categories logic ?>
    </ul>