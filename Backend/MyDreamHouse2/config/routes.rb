Rails.application.routes.draw do
  get 'welcome/index'
  get 'welcome/test'
  get 'welcome/insert'
  get 'ebooks/show'
  #resources :ebooks
  get 'hauspakete/show'
  get 'benutzerrollen/show'
  get 'stammdaten/show'

  root 'welcome#index'
  get 'artribut/show'
  get 'reporting/reportstart'
  get 'zuweisen/zuweisenstart'
  get 'zuweisen/paket'

  get 'welcome/start'
  post 'welcome/start'
 # post 'artribut/show'

   #get 'test/index' => 'test#index'
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html

    #root 'test#index'
end
