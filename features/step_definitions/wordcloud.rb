require 'uri'

Given(/^I am on the word cloud page$/) do
  visit "/LyricFloat/word-cloud.php?"
end

Given(/^there is an existing word cloud/) do
  if find_by_id("wordcloud").has_css?('a')
    true
  else
    visit "/LyricFloat/word-cloud.php?artist_name=coldplay"
  end
end

Then(/^I should see words$/) do
  if find_by_id("wordcloud").has_css?('a')
    !find_by_id('wordcloud').first('a').text().nil?
  else false
  end
end

Then(/^I should be able to click a word$/) do
  find_by_id("wordcloud").has_link?(find_by_id("wordcloud").first('a').text())
end

Then(/^there should not exist the word "(.*?)"$/) do |word|
  find_by_id("wordcloud").all('a', :text => word).nil?
end

Given(/^I create a word cloud of "(.*?)"$/) do |artist|
  visit "/LyricFloat/word-cloud.php?artist_name=" + URI.encode(artist)
end

Then(/^there should be more "(.*?)" than "(.*?)"$/) do |word1, word2|
  word1_size = 10
  puts page.text()
  # find_by_id("wordcloud")
  # page.evaluate_script("$('#wordcloud').text()")
  # word1_size = find_by_id("wordcloud").first('span', :text => word1).css('font-size')
  word2_size = 3 #find_by_id("wordcloud").first('span', :text => word2).css('font-size')
  word1_size > word2_size
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