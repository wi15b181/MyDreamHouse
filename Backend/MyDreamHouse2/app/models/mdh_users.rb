class Mdh_users
	attr_reader :id,:name,:username,:email,:password,:archived
	def initialize(id,name,username,email,password,archived)

		@id=id
		@name=name
		@username=username
		@email=email
		@password=password
		@archived=archived
		
	end
end