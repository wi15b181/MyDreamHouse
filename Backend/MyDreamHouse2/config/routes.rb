Rails.application.routes.draw do
  get 'welcome/index'
  get 'welcome/test'
  get 'welcome/insert'
  get 'ebooks/show'
  #resources :ebooks

  root 'welcome#index'
  get 'artribut/show'
 # post 'artribut/show'

   #get 'test/index' => 'test#index'
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html

    #root 'test#index'
end
