<div class="w-full flex justify-center items-center text-black">
    <div class="flex justify-center items-center gap-2 text-xs">
        <span>Page</span>
        <a class="text-lg" href="{{ $paginator->previousPageUrl() }}">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <form action="">
            <input type="number" max="{{ $paginator->lastPage() }}" min="1" name="page"
                value="{{ $paginator->currentPage() }}" class="w-16 text-center bg-transparent input input-bordered">
        </form>
        <a class="text-lg" href="{{ $paginator->nextPageUrl() }}">
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <span>of</span>
        <span>{{ $paginator->lastPage() }}</span>
    </div>
</div>
