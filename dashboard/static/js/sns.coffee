$ ->
	$('#twitter').popover
		html:true
		content:'''
			<form>
				<h5>请提供您的Twitter账号</h5>
				<div class="input-prepend">
					<span class="add-on">@</span>
					<input class="span2" id="prependedInput" size="233" type="text">
				</div>
				<button class="btn btn-primary" type="button" id="twitter-submit">OK</button>
			</form>
			'''
		placement:'bottom'
	$('body').delegate '#twitter-submit','click',(e)->
		t = $ e.target
		console.log t.parent().children('.input-prepend').children('input').val()