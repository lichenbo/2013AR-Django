from django.core.context_processors import csrf
from django.shortcuts import render_to_response, redirect
from django.http import HttpResponse
from django.template import RequestContext
from datetime import datetime
from models import Record, Comment

def index(request):
		c = {}
		c.update(csrf(request))
		return render_to_response('index.html', c)

def b(request):
		date = datetime.now()
		name = request.POST.get("name")
		phone = request.POST.get("phone")
		number = request.POST.get("number")
		dept = request.POST.get("dept")
		group = request.POST.get("group")
		hobby = request.POST.get("hobby")
		exper= request.POST.get("exper")
		record = Record.objects.create(date=date,name=name,phone=phone,number=number,dept=dept,group=group,hobby=hobby,exper=exper,comment_num=0)
		record.save()
		return HttpResponse('{"success":true}',mimetype="application/json")

def view(request):
		if request.POST.get("name"):
				request.session["name"] = request.POST.get("name")
		if "name" not in request.session:
				return redirect('login.html')
		if request.GET.get("number"):
				c = {}
				c.update(csrf(request))
				c.update({"number": True})
				record = Record.objects.filter(number=request.GET.get("number"))
				try:
					comments = Comment.objects.filter(record=record[0].pk)
				except Comment.DoesNotExist:
					comments = None
				photo_list = comments.get(name="photo").text.split('\n')
				c.update({"record":record, "comments":comments, "edit":False, "photo_list":photo_list})
				if request.GET.get("edit")=="true":
						c.update({"edit":True})
				return render_to_response('view/view.php', c, context_instance=RequestContext(request))
		else:
				c = {}
				for r in Record.objects.all():
						r.comment_num = 0
						r.save()
				for comment in Comment.objects.all():
						# Use ForeignKey Reference to avoid address it 
						comment.record.comment_num += 1
						comment.record.save()
				records = Record.objects.all()
				c.update({"record":records})
				return render_to_response('view/view.php', c, context_instance=RequestContext(request))

def jump2login(request):
		c = {}
		c.update(csrf(request))
		return render_to_response('view/login.html',c)

def getfile(request):
		number = request.GET.get("number")
		name = request.GET.get("name")
		try:
			comment = Comment.objects.get(record=number,name=name).text
		except Comment.DoesNotExist:
			comment = ""
		return HttpResponse(comment)

def addinfo(request):
		number = request.POST.get("number")
		name = request.POST.get("name")
		content = request.POST.get("content")
		objinfo, created = Comment.objects.get_or_create(record=Record.objects.get(number=number), name=name)
		objinfo.text = content
		objinfo.save()
		return HttpResponse("success")
