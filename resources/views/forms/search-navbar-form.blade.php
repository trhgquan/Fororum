<form class="navbar-form navbar-left" action="{{ route('searchWithKeyword') }}" method="POST">
    <div class="form-group">
         <div class="input-group">
             <input type="text" class="form-control" name="keyword" placeholder="Ex: {{ ($action == 'user') ? 'svobod' : 'syria' }}" required>
             <input type="hidden" name="action" value="{{ $action }}">
             <span class="input-group-btn">
                 <button type="submit" class="btn btn-default">tìm</button>
             </span>
         </div>
     </div>
    @csrf
</form>
