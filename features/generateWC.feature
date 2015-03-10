Feature: Generate WC
	Test for geneartion of a word cloud and frequency of words


    Scenario: Size based on frequency
        Given I am on the word cloud page
        And I create a word cloud of "My Favorite Highway"
        Then there should be more "yo" than "drive"

   Scenario: Display Words
        Given I am on the word cloud page
        And there is an existing word cloud
        Then I should see words

    Scenario: Clickable
        Given I am on the word cloud page
        And there is an existing word cloud
        Then I should be able to click a word

    Scenario: Remove Stop Words
        Given I am on the word cloud page
        And there is an existing word cloud
        Then there should not exist the word "the"
        Then there should not exist the word "be"
        Then there should not exist the word "of"
        Then there should not exist the word "to"
        Then there should not exist the word "of"
        Then there should not exist the word "and"        