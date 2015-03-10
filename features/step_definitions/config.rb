require 'capybara/cucumber'
require 'selenium-webdriver'

Capybara.configure do |config|
  config.run_server = false
  config.default_driver = :selenium
  config.app_host = 'http://localhost:8888' # change url
end