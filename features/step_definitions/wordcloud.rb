Given(/^I am on the word cloud page$/) do
  visit "/LyricFloat/word-cloud.php?"
end

Given(/^there is an existing word cloud/) do
  if find_by_id("wordcloud").has_css?('a')
    true
  else
    visit "/LyricFloat/word-cloud.php?artists[]=coldplay"
  end
end

Then(/^I should see words$/) do
  if find_by_id("wordcloud").has_css?('a')
    !find_by_id('wordcloud').first('a').text().nil?
  else false
  end
end

Then(/^I should be able to click a word$/) do
  find("#wordcloud").has_link?(find_by_id("wordcloud").first('a').text())
end

Then(/^there should not exist the word "(.*?)"$/) do |word|
  find("#wordcloud").all('a', :text => word).nil?
end

Given(/^I create a word cloud of "(.*?)"$/) do |artist|
  visit "/LyricFloat/word-cloud.php?artists[]=my+favorite+highway"
end

Then(/^there should be more "(.*?)" than "(.*?)"$/) do |word1, word2|
  word1_size = page.evaluate_script("$(\"span:contains('"+word1+"')\").css('font-size')");
  word2_size = page.evaluate_script("$(\"span:contains('"+word2+"')\").css('font-size')");
  (word1_size > word2_size)
end