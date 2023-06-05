<div>
    @isset($group)
        @isset($user)
            @include('chat.partials.user-chat.topbar.user')
        @else
            @include('chat.partials.user-chat.topbar.group')
        @endisset

        <div class="alert alert-warning alert-dismissible topbar-bookmark fade show p-1 px-3 px-lg-4 pe-lg-5 pe-5" role="alert"
             :class="'d-none'">
            <div class="d-flex align-items-start bookmark-tabs">
                <div class="tab-list-link">
                    <a href="#" class="tab-links" data-bs-toggle="modal" data-bs-target=".pinnedtabModal"><i class="ri-pushpin-fill align-middle me-1"></i> 10 Pinned</a>
                </div>
                <div>
                    <a href="#" class="tab-links border-0 px-3" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="Add Bookmark"><i class="ri-add-fill align-middle"></i></a>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endisset
</div>
