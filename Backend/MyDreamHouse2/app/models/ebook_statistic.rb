class Ebook_statistic
	attr_reader :statistic_id,:statistic_typ,:benutzer_typ,:ebook_id
	def initialize(statistic_id,statistic_typ,benutzer_typ,ebook_id)

		@statistic_id=statistic_id
		@statistic_typ=statistic_typ
		@benutzer_typ=benutzer_typ
		@ebook_id=ebook_id
		
	end
end