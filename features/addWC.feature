Feature: Add WC
    Test for add words to wordcloud

    Scenario: Add Wordcloud
        Given I am on the word cloud page
        	And there is a search text box
        When I type "Avicii" in the search text box
        Given there is an add to cloud button
        	And I click the "Add To Cloud" button
        Then I should be on the "LyricFloat - Word Cloud" page
        	And there should exist the word "magic"
