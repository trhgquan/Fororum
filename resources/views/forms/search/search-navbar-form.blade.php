<form class="navbar-form navbar-left" action="{{ route('search.keyword') }}" method="POST">
    <div class="form-group">
         <div class="input-group">
             <input type="text" class="form-control" name="keyword" placeholder="Ex: {{ ($action == 'profile') ? 'svobod' : 'syria' }}" required>
             <input type="hidden" name="action" value="{{ $action }}">
             <span class="input-group-btn">
                 <button type="submit" class="btn btn-default">Search</button>
             </span>
         </div>
     </div>
    @csrf
</form>
