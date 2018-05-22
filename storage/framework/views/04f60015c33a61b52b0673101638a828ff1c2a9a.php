<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
	<form role="form">
		<legend>Tính điểm</legend>
		<div class="form-group" id="hs1">
			<label for="hs1">Hệ số 1</label>
			<input type="number" class="form-control" name="hs1">
			<a href="#" class="btn" role="button" onclick="addInput(1);return true;">Test</a>
			<input type="hidden" id="totalhs1" value="1">
		</div>

		<div class="form-group" id="hs2">
			<label for="hs2">Hệ số 2</label>
			<input type="number" class="form-control" name="hs2">
			<a href="#" class="btn" role="button" onclick="addInput(2);return true;">Test</a>
			<input type="hidden" id="totalhs2" value="1">
		</div>

		<div class="form-group">
			<label for="hs3">Hệ số 3</label>
			<input type="number" class="form-control" name="hs3">
		</div>

		<a href="#" onclick="tinhDiem();return false;">tinh diem</a>
	</form>
</div>

<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12" id="tongDiem"></div>
