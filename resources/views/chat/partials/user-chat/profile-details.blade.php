<div>
    @isset($group)
        <div class="user-profile-sidebar"
             :class="{ 'd-block': showProfileSidebar }">

            @isset($user)
                @include('chat.partials.user-chat.profile.user')
            @else
                @include('chat.partials.user-chat.profile.group')
            @endisset
        </div>
    @endisset
</div>
