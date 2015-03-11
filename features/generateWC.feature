Feature: Generate WC
    Test for geneartion of a word cloud and frequency of words


    Scenario: Display Words
        Given I am on the word cloud page
        Then I should see words

    Scenario: Clickable
        Given I am on the word cloud page
        Then I should be able to click a word

    Scenario: Remove Stop Words
        Given I am on the word cloud page
        Then there should not exist the word "the"
        Then there should not exist the word "be"
        Then there should not exist the word "of"
        Then there should not exist the word "to"
        Then there should not exist the word "of"
        Then there should not exist the word "and"
        
    Scenario: Size based on frequency
        Given I am on the word cloud page
        And I create a word cloud of "Dolores Hayden"
        Then there should be more "weighs" than "read"
