<!DOCTYPE html>
<html>
<head>
		<script type="text/javascript" src="static/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="static/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="static/jquery.tablesorter.min.js"></script>
		<script type="text/javascript" src="static/jquery-ui.js"></script>
		<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
		<link href="static/tablesorter.css" rel="stylesheet">
		<link href="static/jquery-ui.css" rel="stylesheet">
		<style>
			th {
				white-space:pre;
				padding-right:30px !important;
				font-size:14px !important;
			}
			table {
				font-size:14px !important;
			}
			.alert {
				display:none;
			}
		</style>
</head>
<body>
		<!-- container begin -->
		<div class="container">
				<div class="row">
						<div class="span8 offset2">
								<h1> Welcome to Project LilyPRISM !</h1>
						</div>
				</div>
				<div class="alert">
						<span class="alert-heading"><strong>Notice:</strong></span>
						想要添加照片，请先以<a href="login.html">photo账号登陆</a>，之后在记录中添加图片地址（需要添加"http://"），每张照片一行，不需要任何标签，照片会显示在所有记录的前面
				</div>
				<div class="alert alert-info">你现在登录为<strong>{{request.session.name}}</strong>。<a href='login.html'>不是你？</a>
				</div>
				<table border="2" class="table table-striped tablesorter">
				<thead>
						<tr>
								<th>提交时间</th>
								<th>姓名</th>
								<th>学号</th>
								<th>院系</th>
								<th>联系方式</th>
								<th>组别</th>
								<th>平时经历</th>
								<th>个人爱好</th>
								<th>评论数</th>
						</tr>
				</thead>
				<tbody>
						{% for r in record %}
						<tr>
							{% for name, value in r.get_fields %}
								{% ifequal name "name" %}
								<td><a href="view.php?number={{ r.number }}">{{ value }}</a></td>
								{% else %}
								<td>{{ value }}</td>
								{% endifequal %}
							{% endfor %}
						</tr>
						{% endfor %}
				</tbody>
				</table>

<!-- view.php for displaying overall information end -->

<!-- view.php for displaying specific member start -->

				{% if number %}
					{% for r in record %}
						{% ifequal edit False %}
							<p><a class="btn" href="view.php"><i class="icon-arrow-left"></i>返回列表</a></p>
							<h2><a class='btn btn-success' href='view.php?number={{ r.number }}&edit=true'><i class='icon-pencil icon-white'></i>添加/修改你的记录</a></h2>
							<div class="row pull-right">
										{% for line in photo_list %}
											<img class="span2" src="{{ line }}"></img>
										{% endfor %}
							</div>
								{% for c in comments %}
									<blockquote>
											<p>{{ c.text|linebreaksbr }}</p>
											<small>{{ c.name }}的记录</small>
									</blockquote>
								{% endfor %}
<!-- view.php for displaying specific member end -->
						{% else %}
<!-- view.php for displaying comments start -->
						<p><a class="btn" href="view.php?number={{ r.number }}"><i class="icon-arrow-left"></i>返回评论列表</a></p>

				<form id='formId' class="well form-horizontal" action='addinfo.php' action='post'>
						{% csrf_token %}
						<label class="row">
							<span class="span2">学号:</span>
							<span class="span3">
								<input type="text" id="number"  name="number" value="{{ r.number }}" readonly="readonly"></input>
							</span>
						</label>
						<label class="row">
							<span class="span2">你的名字:</span>
							<span class="span5">
								<input class="span3" type="text" id="name" name="name" value="{{ request.session.name }}" readonly="readonly"></input>
								<span id="msg" class="label label-success" style="display:none;">
								</span>
							</span>

						</label>
						<label class="row">
							<span class="span2">记录一下吧:</span>
							<span class="span6">
								<textarea id="content" class="span6" name="content" rows="10"></textarea>
							</span>
						</label>
					
						<button type="submit" class="btn btn-primary" id="submit">保存</button>
				</form>
			<script>
			$.ajax({
				type:"GET",
				url: "getfile.php",
				data: "number={{ r.number }}&name={{ request.session.name }}",
				success: function(data) {
					$("#content").html(data);
				}
			});
			</script>
						{% endifequal %}
				{% endfor %}
			{% endif %}
		</div>
		<!-- container end -->
</body>
	<script>
	$("#submit").click(function() {
		$.ajax({
			type:"POST",
			url: "addinfo.php",
			data: $("#formId").serialize(),
			success: function(data) {
				$("#msg").show();
				$("#msg").html(data);
				$("#msg").delay(2000).fadeOut();
			}
		});
		return false;
	});

	$(document).ready(function() {
		$(".tablesorter").tablesorter();
		$(".alert").show("shake",{},500,function(){});
	});
	</script>
</html>
