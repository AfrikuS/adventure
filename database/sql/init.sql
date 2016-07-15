CREATE DATABASE adv;

run migrations _user_

CREATE TABLE IF NOT EXISTS `actions` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `code` varchar(255) NOT NULL,
    `duration_seconds` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `action_timers` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `action_code` varchar(255) NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `date_time` DATETIME NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS `hero_things` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `owner_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (owner_id) REFERENCES users(id)
);
ALTER TABLE `hero_things` ADD COLUMN `status` varchar(255) NOT NULL AFTER `title`;

INSERT INTO `hero_things` (title, owner_id) VALUES('Штаны', 1);
INSERT INTO `hero_things` (title, owner_id) VALUES('Штаны', 1);
INSERT INTO `hero_things` (title, owner_id) VALUES('Штаны', 1);
INSERT INTO `hero_things` (title, owner_id) VALUES('Кольчуга', 1);
INSERT INTO `hero_things` (title, owner_id) VALUES('Кольчуга', 1);
INSERT INTO `hero_things` (title, owner_id) VALUES('Кольчуга', 1);

CREATE TABLE IF NOT EXISTS `auction_lot` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `thing_id` INT UNSIGNED NOT NULL,
    `bid` INT NOT NULL,
    `owner_id` INT UNSIGNED NOT NULL,
    `purchaser_id` INT UNSIGNED,
    `date_time` DATETIME NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (thing_id) REFERENCES hero_things(id),
    FOREIGN KEY (owner_id) REFERENCES users(id),
    FOREIGN KEY (purchaser_id) REFERENCES users(id)
);
ALTER TABLE `auction_lot` ADD COLUMN `thing_title` varchar(255) NOT NULL AFTER `thing_id`;
ALTER TABLE `auction_lot` ADD COLUMN `owner_user_name` varchar(255) NOT NULL AFTER `owner_id`;
ALTER TABLE `auction_lot` ADD COLUMN `purchaser_user_name` varchar(255) NOT NULL AFTER `purchaser_id`;

-- // mass bosses


CREATE TABLE IF NOT EXISTS `mass_bosses` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `owner_id` INT UNSIGNED NOT NULL,
    `users_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `kicks` INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (owner_id) REFERENCES users(id)
);
ALTER TABLE `mass_bosses` CHANGE `owner_id` `user_id` INT UNSIGNED NOT NULL;

CREATE TABLE IF NOT EXISTS `mass_boss_users_rels` (
    `boss_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    FOREIGN KEY (boss_id) REFERENCES mass_bosses(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
ALTER TABLE `mass_boss_users_rels` ADD UNIQUE (boss_id, user_id);

CREATE TABLE IF NOT EXISTS `mass_boss_timers` (
    `boss_id` INT UNSIGNED NOT NULL,
    `date_time` DATETIME NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (boss_id),
    FOREIGN KEY (boss_id) REFERENCES mass_bosses(id)
);


-- // resources
CREATE TABLE IF NOT EXISTS `hero_resources` (
    `id` INT UNSIGNED NOT NULL,
    `oil` INT UNSIGNED NOT NULL DEFAULT 0,
    `gold` INT UNSIGNED NOT NULL DEFAULT 0,
    `water` INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES users(id)
);

--, directed
CREATE TABLE IF NOT EXISTS `hero_resource_channels` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `from_user_id` INT UNSIGNED NOT NULL,
    `to_user_id` INT UNSIGNED NOT NULL,
    `resource` varchar(255) NOT NULL,
    `tax_percent` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (from_user_id) REFERENCES users(id),
    FOREIGN KEY (to_user_id) REFERENCES users(id),
    UNIQUE KEY `unique_channel` (`from_user_id`,`to_user_id`,`resource`)
);



CREATE TABLE IF NOT EXISTS `market_temp_shops` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `date_ending` DATETIME NOT NULL,
    PRIMARY KEY (id)
);


CREATE TABLE IF NOT EXISTS `travel_materials_prices` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `shop_id` INT UNSIGNED NOT NULL,
    `code` varchar(255) NOT NULL,
    `material_id` INT UNSIGNED NOT NULL,
    `price` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (shop_id) REFERENCES market_temp_shops(id),
    FOREIGN KEY (material_id) REFERENCES work_catalog_materials(id),
    UNIQUE KEY `unique_shop_material` (`shop_id`, `material_id`)
);

--CREATE TABLE IF NOT EXISTS `geo_travel_orders` (
--    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
--    `traveler_id` INT UNSIGNED NOT NULL,
--    `ship_id` INT UNSIGNED NOT NULL,
--    `type` varchar(255) NOT NULL,
--    `total_amount` INT UNSIGNED NOT NULL,
--    PRIMARY KEY (id),
--    FOREIGN KEY (traveler_id) REFERENCES users(id),
--    FOREIGN KEY (ship_id) REFERENCES geo_travel_ships(id),
--    UNIQUE KEY `unique_traveler_ship` (`traveler_id`, `ship_id`)
--);

+ travel_order_material : order, material
-- geo locations
CREATE TABLE IF NOT EXISTS `geo_locations` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `geo_location_paths` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `from_id` INT UNSIGNED NOT NULL,
    `to_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (from_id) REFERENCES geo_locations(id),
    FOREIGN KEY (to_id) REFERENCES geo_locations(id),
    UNIQUE KEY `unique_from_id_to_id` (`from_id`,`to_id`)
);

CREATE TABLE IF NOT EXISTS `geo_travel_routes` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `title` varchar(255) NOT NULL,
    `status` varchar(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
ALTER TABLE `geo_travel_routes` ADD COLUMN `status` varchar(255) NOT NULL AFTER `title`;


CREATE TABLE IF NOT EXISTS `geo_travel_route_points` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `route_id` INT UNSIGNED NOT NULL,
    `location_id` INT UNSIGNED NOT NULL,
    `status` varchar(255) NOT NULL,
    `number` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (location_id) REFERENCES geo_locations(id),
    FOREIGN KEY (route_id) REFERENCES geo_travel_routes(id)
);

CREATE TABLE IF NOT EXISTS `geo_travel_voyages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `route_id` INT UNSIGNED NOT NULL,
    `point_id` INT UNSIGNED NOT NULL,
    `ship_id` INT UNSIGNED NOT NULL,
    `status` varchar(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (route_id) REFERENCES geo_travel_routes(id),
    FOREIGN KEY (point_id) REFERENCES geo_travel_route_points(id),
    FOREIGN KEY (ship_id) REFERENCES geo_trader_ships(id)
);

CREATE TABLE IF NOT EXISTS `geo_travel_live_voyages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `location_id` INT UNSIGNED NOT NULL,
    `traveler_id` INT UNSIGNED NOT NULL,
    `status` varchar(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (traveler_id) REFERENCES users(id),
    FOREIGN KEY (location_id) REFERENCES geo_locations(id)
);

--  buisness in dock-port-geo

CREATE TABLE IF NOT EXISTS `geo_traders` (
    `id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS `geo_trader_ships` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `owner_id` INT UNSIGNED NOT NULL,
    `route_id` INT UNSIGNED,
    PRIMARY KEY (id),
    FOREIGN KEY (owner_id) REFERENCES geo_traders(id),
    FOREIGN KEY (route_id) REFERENCES geo_travel_routes(id)
);

CREATE TABLE IF NOT EXISTS `geo_trader_temporary_shops` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `owner_id` INT UNSIGNED NOT NULL,
    `date_ending` DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (owner_id) REFERENCES geo_traders(id)
);
-- хранит данные о последних боях между двмя игроками (данные динамические, могут исп-ться).
-- статика обо всех рез-тах сейчас не нужна
CREATE TABLE IF NOT EXISTS `event_attacks` (
    `attack_user_id` INT UNSIGNED NOT NULL,
    `defense_user_id` INT UNSIGNED NOT NULL,
    `attack_moment` DATETIME NOT NULL,
    FOREIGN KEY (`attack_user_id`) REFERENCES users(id),
    FOREIGN KEY (`defense_user_id`) REFERENCES users(id)
--    UNIQUE KEY `unique_attack_user_id_defense_user_id` (`defense_user_id`,`defense_user_id`)
);
ALTER TABLE `event_attacks` ADD COLUMN `defenser_user_name` varchar(255) NOT NULL AFTER `defense_user_id`;



--macro_employment

CREATE TABLE IF NOT EXISTS `macro_resources` (
    `id` INT UNSIGNED NOT NULL,
    `food` INT UNSIGNED NOT NULL,
    `tree` INT UNSIGNED NOT NULL,
    `water` INT UNSIGNED NOT NULL,
    `free_people` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS `macro_timers` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `kind` varchar(255) NOT NULL,
    `people_count` INT UNSIGNED NOT NULL,
    `date_time` DATETIME NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (`user_id`) REFERENCES users(id)
);

--table employment_result_values

CREATE TABLE IF NOT EXISTS `macro_buildings` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `kind` varchar(255) NOT NULL,
    `count` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (`user_id`) REFERENCES users(id)
);
ALTER TABLE `macro_buildings` ADD COLUMN `concrete_building_id` INT UNSIGNED AFTER `count`;


-- кузницы, заводы, метулларгич. кузница не столько кузница, сколько род занятий
CREATE TABLE IF NOT EXISTS `macro_buildings_smiths` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `building_id` INT UNSIGNED NOT NULL,
    `title` varchar(255) NOT NULL,
    `level` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (`user_id`) REFERENCES users(id),
    FOREIGN KEY (`building_id`) REFERENCES macro_buildings(id)
);
ALTER TABLE `macro_buildings_smiths` ADD UNIQUE `unique_building_id`(`building_id`);

-- фермы
CREATE TABLE IF NOT EXISTS `macro_buildings_farms` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `building_id` INT UNSIGNED NOT NULL,
    `title` varchar(255) NOT NULL,
    `level` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (`user_id`) REFERENCES users(id),
    FOREIGN KEY (`building_id`) REFERENCES macro_buildings(id)
);
ALTER TABLE `macro_buildings_farms` ADD UNIQUE `unique_building_id`(`building_id`);



CREATE TABLE IF NOT EXISTS `macro_exchange_goods` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `resource_title` varchar(255) NOT NULL,
    `resource_count` INT UNSIGNED NOT NULL,
    `intent_resource_title` varchar(255) NOT NULL,
    `intentresource_count` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
-- deal - сделка
-- old ?
--CREATE TABLE IF NOT EXISTS `work_skills` (
--    `user_id` INT UNSIGNED NOT NULL,
--    `mine_skill_level` INT UNSIGNED NOT NULL DEFAULT 0,
--    `mines_total` INT UNSIGNED NOT NULL DEFAULT 0,
--    `single_works_times` INT UNSIGNED NOT NULL DEFAULT 0,
--    `mass_works_partner_times` INT UNSIGNED NOT NULL DEFAULT 0,
--    `mass_works_leader_times` INT UNSIGNED NOT NULL DEFAULT 0,
--    PRIMARY KEY (`user_id`),
--    FOREIGN KEY (user_id) REFERENCES users(id)
--);
-- //////////////////////////////////////////

CREATE TABLE IF NOT EXISTS `work_workers` (
    `id` INT UNSIGNED NOT NULL,
    `team_id` INT UNSIGNED,
    `status` varchar(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES users(id),
    FOREIGN KEY (team_id) REFERENCES work_teams(id)
);
-- add unique (id, team_id) воркер может быть тольков  одной команде
--ALTER TABLE `work_team_workers` ADD UNIQUE( `id`, `team_id`);

-- тимоврк где все участники равны, // работа не начнется пока не включатся все участники
CREATE TABLE IF NOT EXISTS `work_teams` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `leader_worker_id` INT UNSIGNED NOT NULL,
    `status` varchar(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (leader_worker_id) REFERENCES work_team_workers(id)
);
-- add unique (leader_worker_id) - воркер может быть лидером только в одной команде

-- отражает рабочий процеес (сам процесс работы команд)

-- роль участника раб процесса в команде для юзера

-- //////////////////////////////////////
CREATE TABLE IF NOT EXISTS `work_catalog_materials` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` varchar(255) NOT NULL,
    `title` varchar(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY `unique_material_code` (`code`)
);


CREATE TABLE IF NOT EXISTS `work_shop_materials` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` varchar(255) NOT NULL,
    `material_id` INT UNSIGNED NOT NULL,
    `price` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (material_id) REFERENCES work_catalog_materials(id),
    UNIQUE KEY `unique_material_code` (`code`)
);

CREATE TABLE IF NOT EXISTS `work_worker_materials` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `code` varchar(255) NOT NULL,
    `value` INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    UNIQUE KEY `unique_user_material` (`code`,`user_id`)
);
-- //////////////////////////////////

CREATE TABLE IF NOT EXISTS `work_catalog_skills` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` varchar(255) NOT NULL,
    `title` varchar(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY `unique_skill_code` (`code`)
);


CREATE TABLE IF NOT EXISTS `work_worker_skills` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `worker_id` INT UNSIGNED NOT NULL,
    `code` varchar(255) NOT NULL,
    `value` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (worker_id) REFERENCES work_workers(id),
    UNIQUE KEY `unique_worker_skill` (`code`,`worker_id`)
);
-- //////////////////////////////////////
CREATE TABLE IF NOT EXISTS `work_catalog_instruments` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` varchar(255) NOT NULL,
    `title` varchar(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY `unique_instrument_code` (`code`)
);

CREATE TABLE IF NOT EXISTS `work_worker_instruments` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `worker_id` INT UNSIGNED NOT NULL,
    `code` varchar(255) NOT NULL,
    `skill_level` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (worker_id) REFERENCES work_workers(id),
    UNIQUE KEY `unique_worker_instrument` (`code`,`worker_id`)
);

CREATE TABLE IF NOT EXISTS `work_shop_instruments` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` varchar(255) NOT NULL,
    `instrument_id` INT UNSIGNED NOT NULL,
    `price` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (instrument_id) REFERENCES work_catalog_instruments(id),
    UNIQUE KEY `unique_instrument_code` (`code`)
);
-- //////////////////////////////////////

-- add complex order for team-worker
--CREATE TABLE IF NOT EXISTS `work_teamorders` (
--    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
--    `desc` varchar(255) NOT NULL,
--    `kind_work` varchar(255) NOT NULL,
--    `price` INT UNSIGNED NOT NULL,
--    `acceptor_team_id` INT UNSIGNED,
--    `status` varchar(255) NOT NULL,
--    PRIMARY KEY (id),
--    FOREIGN KEY (acceptor_team_id) REFERENCES work_teams(id)
--);
--
--CREATE TABLE IF NOT EXISTS `work_teamorder_materials` (
--    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
--    `teamorder_id` INT UNSIGNED NOT NULL,
--    `code` varchar(255) NOT NULL,
--    `need` INT UNSIGNED NOT NULL,
--    `stock` INT UNSIGNED NOT NULL DEFAULT 0,
--    PRIMARY KEY (id),
--    FOREIGN KEY (teamorder_id) REFERENCES work_teamorders(id),
--    UNIQUE KEY `unique_teamorder_material` (`code`,`teamorder_id`)
--);
--
--CREATE TABLE IF NOT EXISTS `work_teamorder_skills` (
--    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
--    `teamorder_id` INT UNSIGNED NOT NULL,
--    `code` varchar(255) NOT NULL,
--    `need_times` INT UNSIGNED NOT NULL DEFAULT 0,
--    `stock_times` INT UNSIGNED NOT NULL DEFAULT 0,
--    PRIMARY KEY (id),
--    FOREIGN KEY (teamorder_id) REFERENCES work_teamorders(id),
--    UNIQUE KEY `unique_teamorder_skill` (`code`,`teamorder_id`)
--);
-- //////////////////////////////////////
CREATE TABLE IF NOT EXISTS `work_order_skills` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` INT UNSIGNED NOT NULL,
    `code` varchar(255) NOT NULL,
    `need_times` INT UNSIGNED NOT NULL DEFAULT 0,
    `stock_times` INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES work_orders(id),
    UNIQUE KEY `unique_order_skill` (`code`,`order_id`)
);
CREATE TABLE IF NOT EXISTS `work_order_materials` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` INT UNSIGNED NOT NULL,
    `code` varchar(255) NOT NULL,
    `need` INT UNSIGNED NOT NULL,
    `stock` INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES work_orders(id),
    UNIQUE KEY `unique_order_material` (`code`,`order_id`)
);

-- single order for one\single worker
CREATE TABLE IF NOT EXISTS `work_orders` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `desc` varchar(255) NOT NULL,
    `type` varchar(255) NOT NULL,
    `status` varchar(255) NOT NULL,
    `kind_work_title` varchar(255) NOT NULL,
    `price` INT UNSIGNED NOT NULL,
    `acceptor_worker_id` INT UNSIGNED,
    `acceptor_team_id` INT UNSIGNED,
    PRIMARY KEY (id),
    FOREIGN KEY (acceptor_worker_id) REFERENCES work_workers(id),
    FOREIGN KEY (acceptor_team_id) REFERENCES work_teams(id)
);

-- предложения вступить в группу\команду - исходят от свободного воркера
CREATE TABLE IF NOT EXISTS `work_team_joinoffers` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `worker_id` INT UNSIGNED NOT NULL,
    `team_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (worker_id) REFERENCES work_workers(id),
    FOREIGN KEY (team_id) REFERENCES work_teams(id),
    UNIQUE KEY `unique_team_worker` (`worker_id`,`team_id`)
);

-- доли доходов от выполнения заказа\ордера
CREATE TABLE IF NOT EXISTS `work_team_reward_pies` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `worker_id` INT UNSIGNED NOT NULL,
    `team_id` INT UNSIGNED NOT NULL,
    `amount_percent` INT UNSIGNED,
    PRIMARY KEY (id),
    FOREIGN KEY (worker_id) REFERENCES work_workers(id),
    FOREIGN KEY (team_id) REFERENCES work_teams(id),
    UNIQUE KEY `unique_pie_worker_team` (`worker_id`,`team_id`)
);





-- BOUNDED CONTEXT        DRIVE
CREATE TABLE IF NOT EXISTS `drive_drivers` (
    `id` INT UNSIGNED NOT NULL,
    `status` varchar(255) NOT NULL,
    `active_vehicle_id` INT UNSIGNED,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES users(id),
    FOREIGN KEY (active_vehicle_id) REFERENCES drive_vehicles(id),
);
ALTER TABLE `drive_drivers` ADD COLUMN `active_vehicle_id` INT UNSIGNED AFTER `status`;
-- add FK on vehicles via migration

CREATE TABLE IF NOT EXISTS `drive_catalog_detail_kinds` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

-- конкретные названия авто-деталей с возможным указанием изготовителя + тип детали (движок, подвеска, ...)
CREATE TABLE IF NOT EXISTS `drive_catalog_details_titles` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `kind_id` INT UNSIGNED NOT NULL,
    `title` varchar(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kind_id) REFERENCES drive_catalog_detail_kinds(id)
);

-- детали для покупки, список обновляется каждый день как в гладах - рынок деталей
CREATE TABLE IF NOT EXISTS `drive_detail_offers` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `kind_id` INT UNSIGNED NOT NULL,
    `nominal_value` INT UNSIGNED NOT NULL,
    `driver_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kind_id) REFERENCES drive_catalog_detail_kinds(id),
    FOREIGN KEY (driver_id) REFERENCES drive_drivers(id)
);


-- все те детали, к-ые есть у дривера
-- детали поставленные у машин, доп атрибуты : текущее состояние, ремонт...
CREATE TABLE IF NOT EXISTS `drive_details` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `kind_id` INT UNSIGNED NOT NULL,
    `nominal_value` INT UNSIGNED NOT NULL,
    `mount_status` varchar(255) NOT NULL,
    `status` varchar(255) NOT NULL,
    `state_percent` INT UNSIGNED NOT NULL,
    `owner_driver_id` INT UNSIGNED NOT NULL,
    `vehicle_id` INT UNSIGNED,
    PRIMARY KEY (id),
    FOREIGN KEY (kind_id) REFERENCES drive_catalog_detail_kinds(id),
    FOREIGN KEY (owner_driver_id) REFERENCES drive_drivers(id),
    FOREIGN KEY (vehicle_id) REFERENCES drive_vehicles(id)
);

-- далее будут структуры для механики разбоя жилищ на тачке
-- gates - врата, fence - забор\ограда\частокол, resources warehouse
CREATE TABLE IF NOT EXISTS `hero_buildings` (
    `id` INT UNSIGNED NOT NULL,
    `gates_level` INT UNSIGNED NOT NULL,
    `fence_level` INT UNSIGNED NOT NULL,
    `door_house_level` INT UNSIGNED NOT NULL,
    `door_ambar_level` INT UNSIGNED NOT NULL,
    `door_resource_warehause_level` INT UNSIGNED NOT NULL, -- todo rename house
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES hero_resources(id)
);
CREATE TABLE IF NOT EXISTS `driver_raids` (
    `id` INT UNSIGNED NOT NULL,
    `vehicle_id` INT UNSIGNED NOT NULL,
    `status` varchar(255) NOT NULL,
    `reward` INT UNSIGNED NOT NULL,
    `start_raid` DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES drive_drivers(id),
    FOREIGN KEY (vehicle_id) REFERENCES drive_vehicles(id)
);



-- нападение разбой - небольшой квестик. механика такая
-- разбивает ворота (если есть) - въезжает во двор, далее разбивает большую дверь,
-- въезжает в малый двор. там три двери (если есть три). выбор в какую биться
-- 1. - ресурсный склад, добыча ресы - нефть бензин
-- 2. - жилище - добыча - золото
-- 3. ресурсный сток, сюда стекаются ресурсы других игроков, к-ые а) сами решили играть по таким правилам
-- и б) проиграли несколько атак и теперь сливают каждый час часть ресурсов этому.
-- так вот взломав дверь сюда - ты можешь узнать путь к одной из жертв\терпил

-- разбой\нападение на 1 лицо - robbery -> redis or node socks
CREATE TABLE IF NOT EXISTS `driver_robberies` (
    `id` INT UNSIGNED NOT NULL,
    `vehicle_id` INT UNSIGNED NOT NULL,
    `victim_id` INT UNSIGNED NOT NULL,
    `status` varchar(255) NOT NULL,
    `start_robbery` DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES drive_drivers(id),
    FOREIGN KEY (vehicle_id) REFERENCES drive_vehicles(id),
    FOREIGN KEY (victim_id) REFERENCES hero_resources(id)
);

CREATE TABLE IF NOT EXISTS `drive_vehicles` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `driver_id` INT UNSIGNED NOT NULL,
    `acceleration` INT UNSIGNED NOT NULL,
    `stability` INT UNSIGNED NOT NULL,
    `mobility` INT UNSIGNED NOT NULL,
    `status` varchar(255) NOT NULL,
    `fuel_level` INT UNSIGNED NOT NULL,
    `damage_percent` INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (driver_id) REFERENCES drive_drivers(id)
);
ALTER TABLE `drive_vehicles` ADD COLUMN `fuel_level` INT UNSIGNED NOT NULL AFTER `mobility`;
ALTER TABLE `drive_vehicles` ADD COLUMN `damage_percent` INT UNSIGNED NOT NULL AFTER `fuel_level`;
ALTER TABLE `drive_vehicles` ADD COLUMN `status` varchar(255) NOT NULL AFTER `damage_percent`;


CREATE TABLE IF NOT EXISTS `drive_raids` (
    `id` INT UNSIGNED NOT NULL,
    `vehicle_id` INT UNSIGNED NOT NULL,
    `status` varchar(255) NOT NULL,

    `victim_id` INT UNSIGNED,
    `robbery_status` varchar(255),

    `reward` INT UNSIGNED NOT NULL,
    `start_raid` DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES drive_drivers(id),
    FOREIGN KEY (vehicle_id) REFERENCES drive_vehicles(id),
    FOREIGN KEY (victim_id) REFERENCES hero_resources(id)
);
ALTER TABLE `drive_raids` CHANGE `raid_status` `status` varchar(255) NOT NULL;



