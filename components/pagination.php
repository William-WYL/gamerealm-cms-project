<!-- Pagination -->
<nav>
  <ul class="pagination justify-content-center">
    <!-- Previous button -->
    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
      <a class="page-link text-dark border-dark bg-white" href="?page=<?= $page - 1 ?>">Prev</a>
    </li>

    <!-- First page -->
    <li class="page-item <?= ($page == 1) ? 'active' : '' ?>">
      <a class="page-link border-dark <?= ($page == 1) ? 'bg-dark text-white' : 'bg-white text-dark' ?>"
        href="?page=1">1</a>
    </li>

    <!-- Ellipsis if needed -->
    <?php if ($page > 4): ?>
      <li class="page-item disabled"><span class="page-link border-dark bg-white text-dark">...</span></li>
    <?php endif; ?>

    <!-- Middle page numbers -->
    <?php
    $start = max(2, $page - 2);
    $end = min($totalPages - 1, $page + 2);
    for ($i = $start; $i <= $end; $i++): ?>
      <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
        <a class="page-link border-dark <?= ($i == $page) ? 'bg-dark text-white' : 'bg-white text-dark' ?>"
          href="?page=<?= $i ?>"> <?= $i ?> </a>
      </li>
    <?php endfor; ?>

    <!-- Ellipsis before the last page -->
    <?php if ($page < $totalPages - 3): ?>
      <li class="page-item disabled"><span class="page-link border-dark bg-white text-dark">...</span></li>
    <?php endif; ?>

    <!-- Last page -->
    <?php if ($totalPages > 1): ?>
      <li class="page-item <?= ($page == $totalPages) ? 'active' : '' ?>">
        <a class="page-link border-dark <?= ($page == $totalPages) ? 'bg-dark text-white' : 'bg-white text-dark' ?>"
          href="?page=<?= $totalPages ?>"> <?= $totalPages ?> </a>
      </li>
    <?php endif; ?>

    <!-- Next button -->
    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
      <a class="page-link text-dark border-dark bg-white" href="?page=<?= $page + 1 ?>">Next</a>
    </li>
  </ul>
</nav>