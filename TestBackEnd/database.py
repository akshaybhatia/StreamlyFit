import sys
import psycopg2

class Database:
	def __init__(self,username,password,database):
		self.username = username
		self.password = password
		self.database = database
		try:
			self.con = psycopg2.connect('dbname=' + database + ' user=' + username + ' password=' + password + ' port=5433') 
		except:
			print "Cannot connect to server. We get the following error message: "
			print sys.exc_info()[1]
			print "Please check your database connection, the configuration, and the credentials, and try again."
			exit
			
	def escape(self,s):
		"""Replace ampersands, pointies, control characters.

			>>> escape('Hello & <world>')
			'Hello &amp; &lt;world&gt;'
			>>> escape('Hello & <world>')
			'Hello &amp; &lt;world&gt;'

		Control characters (ASCII 0 to 31) are stripped away

			>>> escape(''.join([chr(x) for x in range(32)]))
			''

		"""
		s = s.replace('&', '&amp;').replace('<', '&lt;').replace('>', '&gt;')
		s = s.replace('"','').replace("'","")
		return ''.join([c for c in s if ord(c) > 0x1F])

	def insertUser(self,username):
		
		insert_sql="""insert into evolve_users(username) values (%s)"""
		cur = self.con.cursor()
		data = (username,)
		
		try:
			cur.execute(insert_sql,data)
		except:
			print "An error occured while inserting. Here's what the error was: "
			print sys.exc_info()[1]
		self.con.commit()
		cur.close()
		
	def getUsers(self):
		
		get_sql = """select * from evolve_users"""
		cur = self.con.cursor()
		
		try:
			cur.execute(get_sql)
			users = []
			allUsers = cur.fetchall()
			for user in allUsers:
				users.append(user)
			
			return users
		except:
			print "An error occured while inserting. Here's what the error was: "
			print sys.exc_info()[1]
			return None
