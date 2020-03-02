<?php 
require_once("functions.php");
?>
<nav aria-label="Page navigation example">
<?php //  variably display navigation as for now, the search function returns no pages while the default constructor call does  - can probably be done more elegantly"
?>
<?php if (!isset($_POST["type"])) { ?>
    <ul class="pagination">
        <?php
        // yoda rule
        if (1 < $current_results_page) {
        ?>
            <li class="page-item"><a class="page-link" href="/index.php?results_page=<?php echo $current_results_page - 1; ?>">Previous</a></li>
        <?php
        }
        ?>
        <li class=" page-item"><a class="page-link" href="/index.php?results_page=<?php echo $current_results_page; ?>"><?php echo $current_results_page; ?></a></li>
        <?php
        // yoda rule
        if ($current_results_page < $results_page_all) {
        ?>
            <li class="page-item"><a class="page-link" href="/index.php?results_page=<?php echo $current_results_page + 1; ?>">Next</a></li>
        <?php
        }
        ?>
    </ul>
<?php } else {
    // to do when I do styling   
} ?>