<?php if ($pager->getPageCount() > 1) : ?>
    <div class="flex flex-wrap items-center justify-center gap-4 mt-16">
        <a href="<?= $pager->hasPrevious() ? $pager->getPreviousPage() : '#' ?>"
           class="inline-flex items-center px-6 py-3 rounded-full border border-primary text-primary font-bold transition-all <?= $pager->hasPrevious() ? 'hover:bg-primary hover:text-white' : 'opacity-40 pointer-events-none' ?>">
            ← Previous
        </a>

        <div class="flex flex-wrap items-center gap-2">
            <?php
            $query = $_GET;
            $currentPage = isset($query['page']) ? max(1, (int)$query['page']) : 1;
            for ($page = 1; $page <= $pager->getPageCount(); $page++):
                $query['page'] = $page;
                $pageUrl = current_url() . '?' . http_build_query($query);
            ?>
                <a href="<?= $pageUrl ?>"
                   class="h-10 w-10 flex items-center justify-center rounded-full border text-sm font-bold transition-all <?= $page === $currentPage ? 'bg-primary text-white border-primary' : 'border-primary text-primary hover:bg-primary hover:text-white' ?>">
                    <?= $page ?>
                </a>
            <?php endfor; ?>
        </div>

        <a href="<?= $pager->hasNext() ? $pager->getNextPage() : '#' ?>"
           class="inline-flex items-center px-6 py-3 rounded-full border border-primary text-primary font-bold transition-all <?= $pager->hasNext() ? 'hover:bg-primary hover:text-white' : 'opacity-40 pointer-events-none' ?>">
            Next →
        </a>
    </div>
<?php endif; ?>
