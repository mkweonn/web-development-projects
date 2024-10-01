-- Display DVDs that have ‘Widescreen’ format. 
-- Show dvd title, release date, rating, and format.
SELECT dvd_titles.title, dvd_titles.release_date, ratings.rating, formats.format
FROM dvd_titles
LEFT JOIN ratings
	ON dvd_titles.rating_id = ratings.rating_id
LEFT JOIN formats 
	ON dvd_titles.format_id = formats.format_id
WHERE formats.format = 'Widescreen';

-- Display drama (genre) DVDs that won awards. 
-- Sort results by award column. Show dvd title, award, genre, label, and rating.
SELECT dvd_titles.title, dvd_titles.award, genres.genre, labels.label, ratings.rating
FROM dvd_titles
LEFT JOIN genres
	on dvd_titles.genre_id = genres.genre_id
LEFT JOIN labels
	on dvd_titles.label_id = labels.label_id
LEFT JOIN ratings
	on dvd_titles.rating_id = ratings.rating_id
WHERE genres.genre = 'Drama' AND dvd_titles.award IS NOT NULL
ORDER BY dvd_titles.award;


-- Display DVDs made by Universal (label) and have DTS sound. 
-- Show dvd title, sound, label, genre, and rating.
SELECT dvd_titles.title, sounds.sound, labels.label, genres.genre, ratings.rating
FROM dvd_titles
LEFT JOIN sounds
	on dvd_titles.sound_id = sounds.sound_id
LEFT JOIN labels
	on dvd_titles.label_id = labels.label_id
LEFT JOIN genres
	on dvd_titles.genre_id = genres.genre_id
LEFT JOIN ratings
	on dvd_titles.rating_id = ratings.rating_id
WHERE labels.label = 'Universal' AND sounds.sound = 'DTS';

-- Display R-rated Sci-Fi DVDs with release date. 
-- Order results from newest to oldest. 
-- Show dvd title, release date, rating, genre, sound, and label.
SELECT dvd_titles.title, dvd_titles.release_date, ratings.rating, genres.genre, sounds.sound, labels.label
FROM dvd_titles
LEFT JOIN ratings
	on dvd_titles.rating_id = ratings.rating_id
LEFT JOIN genres
	on dvd_titles.genre_id = genres.genre_id
LEFT JOIN sounds
	on dvd_titles.sound_id = sounds.sound_id
LEFT JOIN labels
	on dvd_titles.label_id = labels.label_id
WHERE ratings.rating = 'R' AND genres.genre = 'Sci-Fi' AND dvd_titles.release_date IS NOT NULL
ORDER BY dvd_titles.release_date DESC;

-- Add the movie 'The Godfather'
INSERT INTO dvd_titles(title, release_date, award, format_id, genre_id, label_id, rating_id, sound_id)
VALUES('The Godfather', '1972-03-24', '45th Academy Award for Best Picture', 2, 9, 92, 7, 4);

-- Make the following changes to Zero Effect DVD:
-- New Label: Columbia TriStar 
-- New Genre: Comedy
-- New Format: Fullscreen
UPDATE dvd_titles 
SET label_id = 24, genre_id = 7, format_id = 4 
WHERE dvd_title_id = 5131;

--Delete Major League 3:Back To The Minors from the database.
DELETE FROM dvd_titles
WHERE dvd_title_id = 5932;
-- Tested with: 
-- SELECT title
-- FROM dvd_titles
-- WHERE title = 'Major League 3:Back To The Minors';

-- Display number of characters for the longest and shortest title in the database. 
-- Name columns longest_title and shortest_title respectively. Use aggregate functions.
SELECT MAX(CHAR_LENGTH(title)) AS longest_title, MIN(CHAR_LENGTH(title)) AS shortest_title
FROM dvd_titles;

-- Display all genres and number of DVDs belonging to each genre as dvd_count column. 
-- Show genre ID, genre name, and DVD count. Use an aggregate function.
SELECT genres.genre_id, genres.genre, COUNT(*) AS dvd_count
FROM dvd_titles
LEFT JOIN genres
	ON dvd_titles.genre_id = genres.genre_id
GROUP BY dvd_titles.genre_id;
