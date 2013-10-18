from django.db import models
import datetime

class Record(models.Model):
		date = models.DateField()
		name = models.TextField()
		phone = models.TextField()
		number = models.TextField(primary_key=True)
		dept = models.TextField()
		group = models.TextField()
		hobby = models.TextField()
		exper = models.TextField()
		comment_num = models.IntegerField()
		
		def get_fields(self):
				return [(field.name, field.value_to_string(self)) for field in Record._meta.fields]

class Comment(models.Model):
		record = models.ForeignKey(Record)
		name = models.TextField()
		text = models.TextField()
