<?php

declare(strict_types=1);

?>
<nav aria-label="Page navigation example" class="w-100">
    <?php //  variably display navigation as for now, the search function returns no pages while the default constructor call does  - can probably be done more elegantly"
    ?>
    <?php if (!isset($_POST["type"])) { ?>
        <ul class="pagination">
            <?php
            // yoda rule
            if (1 < $current_results_page_string) {
                ?>
                <li class="page-item"><a class="page-link"
                                         href="/index.php?results_page=<?php echo $current_results_page_string - 1; ?>">Previous</a>
                </li>
                <?php
            }
            ?>
            <li class=" page-item"><a class="page-link"
                                      href="/index.php?results_page=<?php echo $current_results_page_string; ?>"><?php echo $current_results_page_string; ?></a>
            </li>
            <?php
            // yoda rule
            if ($current_results_page_string < $results_page_all_string) {
                ?>
                <li class="page-item"><a class="page-link"
                                         href="/index.php?results_page=<?php echo $current_results_page_string + 1; ?>">Next</a>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php // } else {
        // to do when I do styling
    } ?>
</nav>
