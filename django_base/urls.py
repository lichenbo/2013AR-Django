from django.conf.urls import patterns, include, url

# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    # url(r'^$', 'django_base.views.home', name='home'),
    # url(r'^django_base/', include('django_base.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    # url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    # url(r'^admin/', include(admin.site.urls)),
	url(r'^$', 'view.views.index'),
	url(r'^b.php$', 'view.views.b'),
	url(r'^view.php$', 'view.views.view'),
	url(r'^login.html$', 'view.views.jump2login'),
	url(r'^getfile.php$', 'view.views.getfile'),
	url(r'^addinfo.php$', 'view.views.addinfo'),
)
