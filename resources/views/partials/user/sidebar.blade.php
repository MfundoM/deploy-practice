<div class="col-md-4 mb-4">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="{{ route('logout') }}" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                </div>
            </div>
        </div>
    </div>
    <div class="list-group shadow-sm">
        <a href="{{ route('user.profile.show') }}" class="list-group-item list-group-item-action {{ Ekko::isActiveRoute('user.profile.show') }}" aria-current="{{ Ekko::isActiveRoute('user.profile.show', 'true') }}">My Profile</a>
        <a href="#" class="list-group-item list-group-item-action" aria-current="false">Subscriptions</a>
        <a href="#" class="list-group-item list-group-item-action" aria-current="false">Billing</a>
        <a href="#" class="list-group-item list-group-item-action" aria-current="false">Example</a>
        <a href="#" class="list-group-item list-group-item-action" aria-current="false" data-toggle="modal" data-target="#logoutModal">Logout</a>
    </div>
</div>
