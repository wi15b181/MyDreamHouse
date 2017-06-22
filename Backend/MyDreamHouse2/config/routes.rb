Rails.application.routes.draw do
  get 'welcome/index'

  resources :ebooks

  root 'welcome#index'

   #get 'test/index' => 'test#index'
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html

    #root 'test#index'
end
