/** Setup Script for MySQL databse for BattleShips2D
*   Setups of the database and the tables
    Database name is 'battleships'
*/

CREATE TABLE players (pid int(11) NOT NULL AUTO_INCREMENT, NAME varchar(255), opp_id int(11) default 0, PRIMARY KEY (pid));
CREATE TABLE ship_locations (ship_id int(11) NOT NULL AUTO_INCREMENT, pid int(11), location VARCHAR(255), hit bit(1) default 0, PRIMARY KEY(ship_id));
CREATE TABLE player_guesses (guess_id int(11) NOT NULL AUTO_INCREMENT, pid int(11), opp_id int(11), location VARCHAR(255), PRIMARY KEY(guess_id));
