

<meta name="robots" content="noindex, nofollow">


<style>/* General styles for the single post page */
/* General styles for the single post page */
.single-post {
    background-color: #f9f9f9; /* Light gray background */
    color: #333; /* Dark text color for contrast */
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e0e0e0; /* Light gray border */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
}

/* Styling for paragraphs */
.single-post p {
    border: 1px solid #e0e0e0; /* Light gray border for paragraphs */
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 4px;
    background-color: #fff; /* White background for paragraphs */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); /* Very subtle shadow */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .single-post p {
        font-size: 14px; /* Adjust font size for smaller screens */
    }
}



</style>

<div class="single-post">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            // Output the content of the post
            the_content();
            
            // Example table for demonstration purposes
            ?>

            <?php
            
        endwhile;
    endif;
    ?>
</div>

