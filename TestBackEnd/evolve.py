#!/usr/bin/env python

import cherrypy
import sys
import os
from database import *
from array import *


class PutUsers:
	def index(self,username=None):
		cherrypy.response.headers["Access-Control-Allow-Origin"] = "*"
		database = Database("krangarajan","letmein212","evolve")
		if not username:
			return "Username is required."
		return database.insertUser(username)
	index.exposed = True

class GetUsers:
	def index(self,validated=None,engagement_id=None,plugin_id=None):
		cherrypy.response.headers["Access-Control-Allow-Origin"] = "*"
		cherrypy.response.headers['Content-Type']= 'text/xml'
		database = Database("krangarajan","letmein212","evolve")
		users = database.getUsers()
		xml_data_list = ['<?xml version="1.0" encoding="ISO-8859-1"?>','<users>']
		for user in users:
			xml_data_list.append("<user>%s</user>" % user[1])
		xml_data_list.append("</users>")
		return xml_data_list
	index.exposed = True
	
class Root:
		insert_user = PutUsers()
		get_users = GetUsers()

cherrypy.config.update({'server.socket_host': '0.0.0.0',
                        'server.socket_port': 8080,
                       })
		
cherrypy.quickstart(Root())	

	

