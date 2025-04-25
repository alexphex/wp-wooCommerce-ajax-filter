
<!-- form filter ajax -->
<div class="waf-filter-container">
    <form id="waf-filter-form">
        <select id="waf-category">
            <option value="">Select category</option>
            <?php
            $categories = get_terms( array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
            ));

            foreach ( $categories as $category ) {
                echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
            }
            ?>
        </select>

        <select id="waf-sort">
            <option value="">Sort by</option>
            <option value="popular">Popular</option>
            <option value="new">New</option>
        </select>

        <button type="submit">Filter</button>
    </form>
</div>
<div class="product-list"></div>

<!-- / form filter ajax -->
