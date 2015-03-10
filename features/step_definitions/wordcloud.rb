Given(/^I am on the word cloud page$/) do
  visit "/LyricFloat/word-cloud.php?"
end

Given(/^there is an existing word cloud/) do
  find_by_id("wordcloud").has_css?('a').count > 0
end

# Then(/^I should see a search text box$/) do
#   page.has_field?('artist_name')
# end

# Then(/^I should see a submit button$/) do
#   page.has_button?('Submit')
#   # pending # express the regexp above with the code you wish you had
# end

# Given(/^there exists a search text box$/) do
#   page.has_field?('artist_name')  
# end

# Then(/^I should see autocompleted artists$/) do
#   page.assert_selector('.ui-autocomplete')
# end

# Given(/^that artists names autocomplete$/) do
#   if page.has_field?('artist_name')
#     fill_in 'artist_name', :with => 'Usher'
#     page.find('.ui-autocomplete').first('li').text()=='Usher'
#   end
# end

# When(/^I type "(.*?)" in the search text box$/) do |value|
#   if page.has_field?('artist_name')
#     fill_in 'artist_name', :with => value
#   end
# end

# Then(/^I should see a picture next to the autocomplete results$/) do
#   within('.ui-autocomplete') do 
#     assert_selector('img', :minimum => 1)
#   end
# end

# Given(/^there exists a submit button$/) do
#   page.has_button?('Submit')
# end