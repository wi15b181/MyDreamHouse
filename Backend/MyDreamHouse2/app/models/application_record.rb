class ApplicationRecord < ActiveRecord::Base
  self.abstract_class = true
end

class Ebook < ActiveRecord::Base
  #set_table_name 'ebooks'
  #set_primary_key 'ebook_id'
end
