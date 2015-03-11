Given(/^I am on the home page$/) do
  visit "/LyricFloat/"
end

Then(/^I should see a search text box$/) do
  page.has_field?('artists[]')
end

Then(/^I should see a submit button$/) do
  page.has_button?('Submit')
  # pending # express the regexp above with the code you wish you had
end

Given(/^there exists a search text box$/) do
  page.has_field?('artists[]')  
end

Then(/^I should see autocompleted artists$/) do
  page.assert_selector('.ui-autocomplete')
end

Given(/^that artists names autocomplete$/) do
  if page.has_field?('artists[]')
    fill_in 'artists[]', :with => 'Usher'
    page.find('.ui-autocomplete').first('li').text()=='Usher'
  end
end

When(/^I type "(.*?)" in the search text box$/) do |value|
  if page.has_field?('artists[]')
    fill_in 'artists[]', :with => value
  end
end

Then(/^I should see a picture next to the autocomplete results$/) do
  within('.ui-autocomplete') do 
    assert_selector('img', :minimum => 1)
  end
end

Given(/^there exists a submit button$/) do
  page.has_button?('Submit')
end

Given(/^there exists an add to cloud button$/) do
  page.has_button?('Add To Cloud')
end