<form action="{{ route('logout') }}" method="post">
    @csrf
    <button class="text-white" type="submit">
        <i class="fa fa-sign-out"></i> Logout
    </button>
</form>
