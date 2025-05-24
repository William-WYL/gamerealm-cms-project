-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 09:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamerealm`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Action'),
(2, 'Adventure'),
(15, 'Car Race'),
(10, 'Horror'),
(8, 'Puzzle'),
(3, 'RPG'),
(4, 'Shooter'),
(7, 'Simulation'),
(5, 'Sports'),
(6, 'Strategy'),
(9, 'Survival');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `status` enum('approved','pending','trash') DEFAULT 'approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `game_id`, `content`, `created_at`, `user_id`, `status`) VALUES
(29, 33, 'I spent more than 400 hours playing this masterpiece. Can&#039;t put it down!', '2025-03-27 20:04:02', 1, 'approved'),
(43, 2, 'Best game ever!!!', '2025-03-28 14:40:11', 1, 'trash'),
(59, 1, 'This game is an absolute masterpiece with breathtaking visuals and immersive gameplay. The storyline keeps you engaged from start to finish, and the character development is top-notch. Multiplayer mode adds endless replayability. I highly recommend it to anyone who loves action RPGs. The developers deserve praise for their attention to detail.', '2025-04-21 15:04:36', 1, 'approved'),
(60, 1, 'Incredible experience! The open-world design is vast yet filled with meaningful content. Combat mechanics are smooth, and the skill tree offers deep customization. The soundtrack perfectly complements the atmosphere. A must-play for fans of the genre.', '2025-04-21 15:04:36', 3, 'approved'),
(61, 1, 'I have played over 100 hours and still find new things to explore. The quests are varied, and the NPC interactions feel authentic. Some minor bugs exist, but patches are frequent. A solid 9/10!', '2025-04-21 15:04:36', 4, 'approved'),
(62, 1, 'The graphics are stunning on next-gen consoles. The narrative is emotionally gripping, and the voice acting is superb. Co-op mode with friends is a blast. Definitely worth the price tag.', '2025-04-21 15:04:36', 8, 'approved'),
(63, 1, 'A perfect blend of strategy and action. The crafting system is intuitive, and the loot mechanics keep you hooked. The community is active, and the developers listen to feedback. Can’t wait for DLC!', '2025-04-21 15:04:36', 11, 'approved'),
(64, 2, 'Civilization VI redefines the strategy genre with its deep mechanics and endless possibilities. The district system adds a fresh layer of planning, and the AI provides a decent challenge. A must-have for strategy enthusiasts.', '2025-04-21 15:04:49', 12, 'approved'),
(65, 2, 'The historical accuracy and leader diversity are impressive. Multiplayer games with friends are intensely fun. The expansions add significant content, making it a complete package.', '2025-04-21 15:04:49', 13, 'approved'),
(66, 2, 'Learning curve is steep but rewarding. The mod support extends the game’s lifespan. I’ve sunk 200+ hours and still crave more. Highly addictive!', '2025-04-21 15:04:49', 14, 'approved'),
(67, 2, 'Beautiful art style and smooth UI. The new climate change mechanic adds urgency to late-game decisions. Diplomacy could be improved, but overall a stellar experience.', '2025-04-21 15:04:49', 15, 'approved'),
(68, 2, 'A timeless classic. Every playthrough feels unique thanks to randomized maps and events. The soundtrack is iconic. 10/10 would recommend.', '2025-04-21 15:04:49', 16, 'approved'),
(69, 3, 'Elden Ring\'s open world redefines exploration. The sense of discovery when finding hidden catacombs or dragons is unmatched. Combat is precise, and build variety encourages multiple playthroughs. A true FromSoftware masterpiece!', '2025-04-21 15:07:50', 17, 'approved'),
(70, 3, 'The legacy dungeons like Stormveil Castle are intricately designed. Torrent (your spectral steed) makes traversal a joy. The lore via item descriptions is Dark Souls at its best. Prepare to die... a lot!', '2025-04-21 15:07:50', 1, 'approved'),
(71, 3, 'Performance on PC has improved with patches. Ray tracing adds stunning lighting effects. Co-op with friends via summon signs works seamlessly. Best Game of the Year 2022 deserved!', '2025-04-21 15:07:50', 3, 'approved'),
(72, 3, 'The weapon arts system allows for creative combat approaches. Nighttime cycles change enemy behavior – brilliant touch. Environmental storytelling is peerless. 100+ hours well spent!', '2025-04-21 15:07:50', 4, 'approved'),
(73, 3, 'Boss designs like Radahn and Malenia are unforgettable. The soundtrack swells at perfect moments. Jump attacks finally feel viable. FromSoft\'s magnum opus!', '2025-04-21 15:07:50', 8, 'approved'),
(74, 4, 'Tears of the Kingdom expands Hyrule vertically in genius ways. Building contraptions with Ultrahand is endlessly creative. The Depits add a terrifying survival horror layer. Nintendo\'s magic is alive and well!', '2025-04-21 15:07:50', 11, 'approved'),
(75, 4, 'The new Recall ability creates mind-bending puzzles. Fusing weapons leads to hilarious combinations (stick + boulder = ultimate hammer!). Sky islands offer breathtaking vistas. Best Switch exclusive!', '2025-04-21 15:07:50', 12, 'approved'),
(76, 4, 'Performance holds steady at 30 FPS – a miracle for Switch hardware. The story ties beautifully to Breath of the Wild\'s lore. Master Kohga\'s return had me laughing out loud!', '2025-04-21 15:07:50', 13, 'approved'),
(77, 4, 'Shrines are more inventive than ever. Armor upgrades via Great Fairies add depth. The final boss sequence is an emotional rollercoaster. A perfect sequel!', '2025-04-21 15:07:50', 14, 'approved'),
(78, 4, 'The soundtrack dynamically adapts to your actions – riding a horse at sunset with piano melodies is magical. Weapon durability still divisive, but fusing mitigates it. 10/10!', '2025-04-21 15:07:50', 15, 'approved'),
(79, 5, 'Starfield delivers Bethesda\'s trademark freedom in space. Ship building is incredibly deep – spent hours crafting my perfect cruiser. Planetary exploration needs more POIs, but mods will fix that!', '2025-04-21 15:07:50', 16, 'approved'),
(80, 5, 'The faction quests (especially UC Vanguard) have Mass Effect-level writing. Zero-G combat feels fresh. Photo mode captures stunning nebula backdrops. A foundation for something legendary!', '2025-04-21 15:07:50', 17, 'approved'),
(81, 5, 'Performance on Series X is smooth with occasional loading screens. The lockpicking minigame is their best yet. Outpost building needs QoL patches. Still, I\'m hooked!', '2025-04-21 15:07:50', 1, 'approved'),
(82, 5, 'New Game+ has a brilliant narrative twist. The soundtrack blends orchestral and synth perfectly. Companions like Sarah Morgan are memorable. Skyrim in space achieved!', '2025-04-21 15:07:50', 3, 'approved'),
(83, 5, 'The silence of space during EVA missions is haunting. Criminal smuggling runs add Firefly-esque thrills. Needs more alien species, but DLC potential is massive!', '2025-04-21 15:07:50', 4, 'approved'),
(84, 6, 'Baldur\'s Gate III is a triumph of CRPG design. The depth of choice in dialogue and quests is staggering – I replayed Act 1 three times just to see different outcomes. The turn-based combat rewards tactical thinking, and the spell effects are visually spectacular. Larian Studios nailed the D&D 5e adaptation!', '2025-04-21 15:10:54', 8, 'approved'),
(85, 6, 'The character customization goes beyond race/class – your background actually impacts NPC reactions. The motion-captured facial animations make conversations feel alive. Multiplayer with friends creates hilarious emergent storytelling. Early access was worth every penny!', '2025-04-21 15:10:54', 11, 'approved'),
(86, 6, 'Playing as Dark Urge adds a thrilling layer of moral complexity. Environmental interactions (throw grease bottle then ignite it!) create endless combat possibilities. Performance is smooth on mid-range PCs. A new gold standard for RPGs!', '2025-04-21 15:10:54', 12, 'approved'),
(87, 6, 'The voice acting deserves awards – especially Neil Newbon as Astarion. Camp scenes develop party members\' backstories beautifully. The inventory management could use improvement, but that\'s my only gripe. 150 hours in and still discovering secrets!', '2025-04-21 15:10:54', 13, 'approved'),
(88, 6, 'Divinity: Original Sin 2 fans will feel right at home. The verticality in combat (shove enemies off cliffs!) is genius. The evil playthrough offers shocking narrative branches. A masterpiece that respects player agency.', '2025-04-21 15:10:54', 14, 'approved'),
(89, 7, 'Phantom Liberty transforms Night City into a spy thriller playground. Idris Elba\'s Solomon Reed is mesmerizing – his loyalty missions had me on edge. The new Dogtown district oozes danger with its black market vibe. Car chases with improved physics are adrenaline-pumping!', '2025-04-21 15:10:54', 15, 'approved'),
(90, 7, 'The relic skill tree adds OP abilities that make you feel like a cyber-ninja. Ray tracing Overdrive mode makes neon signs reflect in every puddle. The \"Killing Moon\" ending left me emotionally wrecked. CD Projekt Red\'s redemption arc complete!', '2025-04-21 15:10:54', 16, 'approved'),
(91, 7, 'Vehicle combat finally done right – shooting from bikes while dodging drones is pure joy. The redesigned police system creates GTA-style chaos. Netrunner builds feel viable now with quickhack combos. A must-play for 2.0 update newcomers!', '2025-04-21 15:10:54', 17, 'approved'),
(92, 7, 'Playing on PS5 with haptic feedback – you feel every raindrop and subway rumble. The new wardrobe system lets you keep stats while looking fabulous. Judy Alvarez\'s expanded role warms my heart. 10/10 expansion!', '2025-04-21 15:10:54', 1, 'approved'),
(93, 7, 'The spy gadgets (optical camo, projectile launcher) add fresh approaches to missions. Random car thefts lead to hilarious NPC reactions. Path tracing makes Night City the best-looking game world ever. Edgerunners cameos are chefs kiss!', '2025-04-21 15:10:54', 3, 'approved'),
(94, 8, 'As a Potterhead since childhood, flying over Hogwarts on a broom brought tears to my eyes. The castle is meticulously detailed – moving staircases, secret passages, the works! Combat spells chain together like magical combos. Pure nostalgia magic!', '2025-04-21 15:10:54', 4, 'approved'),
(95, 8, 'The Room of Requirement customization is addicting – I spent hours breeding graphorns and decorating. Sebastian\'s dark arts storyline has shocking twists. Merlin trials get repetitive, but exploring the Highlands never gets old.', '2025-04-21 15:10:54', 8, 'approved'),
(96, 8, 'PlayStation-exclusive quest with Hogsmeade shop is a clever business sim minigame. The soundtrack weaves familiar motifs with new themes. Wish there were more consequences for using unforgivable curses though!', '2025-04-21 15:10:54', 11, 'approved'),
(97, 8, 'Character creation needs more diversity, but the voice acting (especially the sassy goblins) compensates. Broom racing against Natty is my favorite side activity. A solid foundation for future Wizarding World games!', '2025-04-21 15:10:54', 12, 'approved'),
(98, 8, 'The herbology system is surprisingly deep – mandrakes actually scream when harvested! Dark Arts Arena DLC lets you go full Voldemort. Performance mode on Series X maintains 60FPS beautifully. Accio sequel!', '2025-04-21 15:10:54', 13, 'approved'),
(99, 9, 'Final Fantasy XVI\'s Eikon battles redefine epic scale – Bahamut vs. Phoenix had me screaming at my TV. The mature political story feels like Game of Thrones meets FF lore. Active Time Lore system is genius for newcomers!', '2025-04-21 15:10:54', 14, 'approved'),
(100, 9, 'Combat director Ryota Suzuki (DMC5) delivers – Clive\'s swordplay is weighty yet fluid. The soundtrack by Soken alternates between haunting vocals and pulse-pounding metal. Hunt board monsters provide satisfying challenges.', '2025-04-21 15:10:54', 15, 'approved'),
(101, 9, 'Performance mode suffers from resolution drops, but Graphics mode\'s 30FPS is cinematic. Side quests start slow but build meaningful world connections. Cid\'s voice actor deserves all the awards!', '2025-04-21 15:10:54', 16, 'approved'),
(102, 9, 'The lack of party control hurts, but Jill and Torgal\'s AI is competent. Chronolith trials test your mastery of Eikon abilities. New Game+ with Ultimaniac difficulty is brutally rewarding. A bold new direction!', '2025-04-21 15:10:54', 17, 'approved'),
(103, 9, 'The Hideaway hub evolves beautifully through the story. Orchestrion rolls let you replay iconic tracks. Japanese voice acting captures emotional nuance perfectly. This is what next-gen Final Fantasy should be!', '2025-04-21 15:10:54', 1, 'approved'),
(104, 10, 'Switching between Peter and Miles mid-swing is seamless. The symbiote suit mechanics make you feel terrifyingly powerful. Brooklyn and Queens expansions double the web-slinging playground. Best superhero game ever made!', '2025-04-21 15:10:54', 3, 'approved'),
(105, 10, 'Hailey\'s deafness-focused mission is a masterpiece of sensory storytelling. The wingsuit adds new verticality to traversal. Boss fights against Kraven and Venom are cinematic spectacles. Photo mode captures NYC in stunning detail!', '2025-04-21 15:10:54', 4, 'approved'),
(106, 10, 'Ray tracing reflections in puddles and windows make Manhattan feel alive. The new parry system adds depth to combat. J. Jonah Jameson\'s podcast rants during traversal are comedy gold!', '2025-04-21 15:10:54', 8, 'approved'),
(107, 10, 'Miles\' evolved venom powers create electric combos. The Emily-May Foundation side missions add emotional weight. Fast travel is instant – literally a blur effect! Co-op would be nice, but this is near-perfect.', '2025-04-21 15:10:54', 11, 'approved'),
(108, 10, 'The symbiote tendrils during rage mode are viscerally satisfying. Accessibility options set new standards – full arachnophobia mode! Can\'t wait for the inevitable Spider-Gwen DLC.', '2025-04-21 15:10:54', 12, 'approved'),
(109, 11, 'Persona 5 redefines the JRPG genre with its stylish UI and gripping social sim elements. Balancing school life as a phantom thief creates addictive gameplay loops. The jazz soundtrack is perfection – I still listen to \"Last Surprise\" daily. Palace designs like Madarame\'s museum are creative masterpieces. A true modern classic!', '2025-04-21 15:13:59', 14, 'approved'),
(110, 11, 'The confidant system makes every NPC relationship meaningful. Makoto\'s character arc from strict council president to badass biker is unforgettable. Negotiating with shadows adds strategic depth to combat. Royal edition content elevates it to GOAT status!', '2025-04-21 15:13:59', 15, 'approved'),
(111, 11, 'Playing on PS5 with 60 FPS makes the anime cutscenes buttery smooth. Mementos grinding can feel repetitive, but the payoff in ultimate personas is worth it. The themes of rebellion against societal corruption remain powerfully relevant.', '2025-04-21 15:13:59', 16, 'approved'),
(112, 11, 'Fusion mechanics require careful planning – accidentally losing a favorite persona hurts! The third semester reveal completely reshaped my moral perspective. Coffee-making sim at Leblanc is weirdly therapeutic. 100+ hours flew by!', '2025-04-21 15:13:59', 17, 'approved'),
(113, 11, 'Joker\'s silent protagonist works surprisingly well, letting your choices define him. Baton pass combos make team synergy crucial. The final boss theme \"Swear to My Bones\" gives me chills every time. A must-play for anime fans!', '2025-04-21 15:13:59', 1, 'approved'),
(114, 33, 'Nioh 2\'s combat system is a masochist\'s dream – punishing yet deeply rewarding. The Yokai shift mechanics add new layers to the stamina management. Creating your own half-demon character makes the story more personal than the first game.', '2025-04-21 15:13:59', 3, 'approved'),
(115, 33, 'Weapon variety puts Souls games to shame – splitstaff and switchglaive combos feel incredible. The Dark Realm mechanic forces aggressive playstyles. Co-op expeditions make tough bosses manageable. A hidden gem of the action genre!', '2025-04-21 15:13:59', 4, 'approved'),
(116, 33, 'The historical fantasy setting blending Sengoku era and Japanese mythology is fascinating. Sudama trading adds fun randomization. Farming ethereal graces requires dedication but creates OP builds. Best played with a controller!', '2025-04-21 15:13:59', 8, 'approved'),
(117, 33, 'Depth of build customization is staggering – spent hours perfecting my ninjutsu thrower. The three-way DLC conflict between Hide, Otakemaru, and Saito Yoshitatsu delivers emotional gut punches. Underrated narrative masterpiece!', '2025-04-21 15:13:59', 11, 'approved'),
(118, 33, 'Tate Eboshi boss fight is pure rhythm game perfection. The new burst counter system makes every enemy encounter strategic. Kodama collecting remains oddly satisfying. Team Ninja\'s finest work!', '2025-04-21 15:13:59', 12, 'approved'),
(119, 67, 'Ragnarök delivers an emotionally charged conclusion to Kratos and Atreus\' journey. The axe-throwing combat feels weightier than ever, and the new elemental abilities add devastating combos. The scene with Fenrir\'s birth destroyed me emotionally.', '2025-04-21 15:13:59', 1, 'approved'),
(120, 67, 'DualSense haptics make every shield bash visceral. The RPG elements are streamlined without losing depth. Muspelheim trials provide endless challenge. Sindri\'s character arc is Shakespearean tragedy. Masterpiece!', '2025-04-21 15:13:59', 3, 'approved'),
(121, 67, 'The norse mythology integration is flawless – meeting Ratatoskr\'s multiple personalities is hilarious. Berserker gravestones offer brutal optional bosses. Photo mode captures breathtaking vistas of the Nine Realms.', '2025-04-21 15:13:59', 4, 'approved'),
(122, 67, 'Atreus\' shapeshifting sections add welcome variety. The dynamic between Brok and Mimir provides perfect comic relief. NG+ with Zeus armor turns Kratos into an unstoppable force. Best PS5 exclusive to date!', '2025-04-21 15:13:59', 8, 'approved'),
(123, 67, 'The \"Gná\" Valkyrie fight surpasses Sigrun\'s difficulty from the first game. The orchestral score elevates every story beat. Accessibility options let anyone experience this father-son epic. Santa Monica Studio outdid themselves!', '2025-04-21 15:13:59', 11, 'approved'),
(124, 68, 'Forbidden West\'s machine designs reach new heights – the Slitherfang battle is pure spectacle. The underwater exploration with rebreather adds stunning biomes. Weapon stamina system encourages strategic loadout choices.', '2025-04-21 15:13:59', 12, 'approved'),
(125, 68, 'Performance mode on PS5 maintains 60 FPS flawlessly. The new Valor Surge abilities make combat more dynamic. Aloy\'s character development shows vulnerability beneath her warrior exterior. A technical marvel!', '2025-04-21 15:13:59', 13, 'approved'),
(126, 68, 'The Machine Strike board game is shockingly addictive. Tallneck override sequences provide breathtaking platforming. The Quen tribe\'s storyline explores fascinating post-apocalyptic politics. Best use of haptic feedback since Astro!', '2025-04-21 15:13:59', 14, 'approved'),
(127, 68, 'Photo mode captures every scale on the Tremortusk. The Burning Shores DLC introduces cloud-skimming mechanics that redefine traversal. Lance Reddick\'s final performance as Sylens is hauntingly beautiful.', '2025-04-21 15:13:59', 15, 'approved'),
(128, 68, 'The food crafting system adds survival elements without being tedious. Rebel outpost stealth missions could use more variety. Overall, Guerrilla Games sets a new bar for open-world design. Can\'t wait for the third installment!', '2025-04-21 15:13:59', 16, 'approved'),
(129, 70, 'Stray\'s cyberpunk cat adventure is a masterpiece of atmosphere. The way light filters through neon signs onto rain-soaked alleys creates a haunting beauty. Platforming feels intuitive for a feline - leaping between AC units and squeezing through gaps never gets old. B-12\'s story arc delivers unexpected emotional weight. A must-play for anyone who values unique narratives.', '2025-04-21 15:19:10', 17, 'approved'),
(130, 70, 'Purring controller vibrations on PS5 are purr-fect immersion. The zurk chase sequences ramp up tension brilliantly. Environmental storytelling through robot interactions speaks volumes without words. Short but impactful - left me wanting a sequel featuring the cat\'s journey outside the city!', '2025-04-21 15:19:10', 1, 'approved'),
(131, 70, 'Keyboard controls take getting used to, but the game shines with a controller. The soundtrack\'s synthwave beats perfectly complement exploration. Photo mode captures hilarious cat antics like knocking paint cans off ledges. A love letter to both cats and cyberpunk aesthetics.', '2025-04-21 15:19:10', 3, 'approved'),
(132, 70, 'Puzzle design strikes the perfect balance - challenging enough to feel rewarding without frustration. The emotional gut-punch of certain memories found in the slums stayed with me for days. More games should embrace non-human protagonists this effectively!', '2025-04-21 15:19:10', 4, 'approved'),
(133, 70, 'The attention to feline behavior is astounding - from rubbing against legs to obsessive box-sitting. Co-op play would have been amazing, but solo experience remains magical. Final sequence with B-12 had me in tears. Indie gaming at its finest!', '2025-04-21 15:19:10', 8, 'approved'),
(135, 71, 'The reactive R-301 skin evolving with kills adds satisfying progression. Mixtape mode rotation keeps casual play fresh. Server stability massively improved since last season. New ping system for suggesting loadouts revolutionizes team coordination.', '2025-04-21 15:19:10', 12, 'approved'),
(136, 71, 'Weapon mastery badges add long-term grind goals. Firing range dummy AI now mimics strafe patterns from top players. Cross-progression finally lets me switch between PC and console seamlessly. Respawn keeps this BR king on its throne!', '2025-04-21 15:19:10', 13, 'approved'),
(137, 71, 'Control mode becoming permanent was a genius move. The new Evac Tower item enables insane repositioning plays. Character-specific heirlooms feel more meaningful than ever. Best FPS for adrenaline-pumping squad gameplay!', '2025-04-21 15:19:10', 14, 'approved'),
(138, 71, 'Accessibility options like audio visualizer for footsteps set new standards. Clan system needs more incentives but shows promise. Nemesis AR meta keeps mid-range engagements intense. Five years strong and still evolving!', '2025-04-21 15:19:10', 15, 'approved'),
(139, 72, 'Warhammer III\'s Immortal Empires mode is the ultimate strategy sandbox. Coordinating Kislev\'s bear cavalry with Ice Guard archers never gets old. Chaos Realm mechanics add risk-reward layer to expansion. Performance optimization makes late-game turns manageable.', '2025-04-21 15:19:10', 16, 'approved'),
(140, 72, 'The new Chorfs faction balances industry and magic perfectly. Artillery duels between Hellcannons and Empire rockets are cinematic. Campaign narrative branching based on god alignment adds replay value. Mod support ensures infinite content!', '2025-04-21 15:19:10', 17, 'approved'),
(141, 72, 'Siege battles with multi-layered city defenses are revolutionary. Ogre Kingdoms\' meat economy leads to hilarious snowball strategies. The \"End Times\" crisis events keep late-game challenging. A love letter to Warhammer Fantasy fans!', '2025-04-21 15:19:10', 1, 'approved'),
(142, 72, 'Diplomacy overhaul makes alliances feel impactful. Daemon Prince customization allows terrifying combinations. Spectator mode revolutionizes multiplayer tournaments. The pinnacle of Total War design!', '2025-04-21 15:19:10', 3, 'approved'),
(143, 72, 'Blood DLC effects elevate combat brutality. Settlement trading adds new strategic depth. Regiments of Renown provide game-changing elite units. Thousands of hours of content packed into one title!', '2025-04-21 15:19:10', 4, 'approved'),
(144, 73, 'Forza Horizon 5\'s Mexican landscape is a visual feast. Dust storms in the desert and tropical rains in jungles make every race unique. Car mastery trees add RPG elements to vehicle customization. The Vocho storyline is a nostalgic trip!', '2025-04-21 15:19:10', 8, 'approved'),
(145, 73, 'Hoonigan pack brings insane drift machines. Event Lab creations range from Mario Kart-style tracks to horror mazes. Engine swaps let you turn a VW Beetle into a tire-shredding monster. Photo mode captures golden hour perfection!', '2025-04-21 15:19:10', 11, 'approved'),
(146, 73, 'Accolades system encourages trying every activity. The Hot Wheels expansion defies physics in the best way. Engine sounds are recorded from real cars - the LFA\'s scream is eargasm! Endless content for gearheads.', '2025-04-21 15:19:10', 12, 'approved'),
(147, 73, 'Horizon Arcade co-op challenges are chaotic fun. Auction house sniping rare cars never gets old. Custom liveries range from photorealistic to absurd meme machines. The ultimate chill racing experience!', '2025-04-21 15:19:10', 13, 'approved'),
(148, 73, 'Accessibility features like rewind and auto-brake welcome newcomers. Seasonal challenges keep the map fresh. Converting any car into a rally beast with suspension mods is genius. Playground Games outdid themselves!', '2025-04-21 15:19:10', 14, 'approved'),
(149, 76, 'Cities: Skylines II\'s traffic AI revolutionizes urban planning. Watching citizens dynamically choose routes based on real-time congestion is mesmerizing. Mixed zoning creates organic neighborhood growth. The learning curve is steep but rewarding!', '2025-04-21 15:19:10', 15, 'approved'),
(150, 76, 'Procedural architecture makes every skyline unique. Pollution management requires careful industrial placement. Mod support brings insane creations like zombie outbreaks. A city builder\'s dream come true!', '2025-04-21 15:19:10', 16, 'approved'),
(151, 76, 'Weather systems impact gameplay - floods require emergency drainage systems. Public transport routes can be micro-managed down to individual bus stops. The soundtrack\'s ambient tracks perfect for marathon sessions!', '2025-04-21 15:19:10', 17, 'approved'),
(152, 76, 'District policies add political depth - legalize gambling to boost tourism at moral cost. Asset recycling reduces landfill dependency. Natural disasters keep mayors on their toes. Infinite replay value!', '2025-04-21 15:19:10', 1, 'approved'),
(153, 76, 'Citizen lifecycles from birth to death add emotional weight. Tax sliders balance budgets like a real economy. European building style DLC brings charming row houses. The new gold standard for sim games!', '2025-04-21 15:19:10', 3, 'approved'),
(154, 77, 'Returnal\'s roguelike loop is brutally addictive. Unlocking permanent gear upgrades makes each run feel meaningful. The haptic feedback during alien rain sequences is next-level immersion. Story revelations about Selene\'s past are mind-bending!', '2025-04-21 15:19:10', 4, 'approved'),
(155, 77, 'Tower of Sisyphus mode tests skill ceilings. Co-op makes boss fights manageable while keeping tension high. The Electropylon Driver build turns you into a walking death grid. DualSense triggers simulate every alt-fire mode uniquely!', '2025-04-21 15:19:10', 8, 'approved'),
(156, 77, 'Biome randomization keeps runs fresh. Audio design makes you feel every squelchy step in crimson wastes. The secret ending requires dedication but delivers existential chills. Housemarque\'s masterpiece!', '2025-04-21 15:19:10', 11, 'approved'),
(157, 77, 'Daily challenge leaderboards fuel competition. The grapple hook adds Spider-Man mobility to combat. Scout logs gradually piece together the cosmic horror narrative. A PS5 showcase title!', '2025-04-21 15:19:10', 12, 'approved'),
(158, 77, 'Suspend cycle feature saves progress without breaking roguelike tension. Unused controller speaker whispers creepy alien dialect. Hyperion boss fight with rising organ music is gaming history!', '2025-04-21 15:19:10', 13, 'approved'),
(159, 78, 'Monster Hunter Rise: Sunbreak\'s new switch skills revolutionize weapon play. Countering with the Longsword\'s Sacred Sheathe feels immensely satisfying. The Malzeno armor set bonus enables vampiric combat styles!', '2025-04-21 15:19:10', 14, 'approved'),
(160, 78, 'Followers system lets you hunt with NPC allies - Hinoa\'s healing saves tough fights. Anomaly investigations provide endless endgame grind. The new \"Bloodening\" status adds risk-reward mechanics. Best expansion since Iceborne!', '2025-04-21 15:19:10', 15, 'approved'),
(161, 78, 'Wirebug mobility makes vertical maps a playground. Rampage missions improved but still divisive. Fashion hunting reaches new heights with layered armor combinations. Monster ride collisions are hilarious!', '2025-04-21 15:19:10', 16, 'approved'),
(162, 78, 'Lucen Wyvern\'s light beam attacks demand perfect positioning. Qurio crafting adds build diversity. The final Gaismagorm battle is an epic spectacle. Cross-save with Switch lets me hunt anywhere!', '2025-04-21 15:19:10', 17, 'approved'),
(163, 78, 'New endemic life like Marionette Spiders enable creative trap setups. Buddy customization with cute outfits never gets old. Capcom keeps delivering content - title updates feel like sequels!', '2025-04-21 15:19:10', 1, 'approved'),
(164, 79, 'Overwatch 2\'s 5v5 format increases individual impact. Kiriko\'s teleport cleanses make support play thrilling. New Push mode maps require smart rotations. Battle pass progression needs tuning but core gameplay shines!', '2025-04-21 15:19:10', 3, 'approved'),
(165, 79, 'Junker Queen\'s knife combos are brutally fun. Mythic skins like Cyber Demon Genji set customization benchmarks. Crossplay balance between platforms is impressive. Returning to the payload never felt better!', '2025-04-21 15:19:10', 4, 'approved'),
(166, 79, 'Sojourn\'s railgun rewards precision aim. Reworked Bastion feels viable without being OP. Map voting system reduces repetition. Clan tags and profiles add social depth. The FPS hero shooter king returns!', '2025-04-21 15:19:10', 8, 'approved'),
(167, 79, 'Leaver penalties keep matches competitive. Workshop modes enable hilarious custom games. PvE story missions flesh out character lore. Sound design makes every ability impactful. Free-to-play done right!', '2025-04-21 15:19:10', 11, 'approved'),
(168, 79, 'New ping system enhances team coordination without voice chat. Ramattra\'s Nemesis Form dominates frontlines. Anniversary remix skins refresh classic looks. Overwatch League viewership tools set esports standard!', '2025-04-21 15:19:10', 12, 'approved'),
(169, 80, 'Witcher 3 Next-Gen\'s ray tracing transforms Toussaint into a painting. Quick casting signs streamline combat. The new quest involving Philippa\'s spy network adds political intrigue. Photo mode captures Geralt\'s brooding perfectly!', '2025-04-21 15:19:10', 13, 'approved'),
(170, 80, 'Netflix armor sets blend show and game aesthetics. Community mod integrations like HD Reworked Project are seamless. Cross-save lets me continue my Switch progress on PC. Still the RPG benchmark after 8 years!', '2025-04-21 15:19:10', 14, 'approved'),
(171, 80, 'DualSense adaptive triggers simulate drawing Geralt\'s bow. FSR 2.0 boosts performance on mid-range GPUs. New dialogue options with Regis add character depth. A masterclass in remastering!', '2025-04-21 15:19:10', 15, 'approved'),
(172, 80, 'Horse racing controls feel modernized. The Slavic folklore-inspired soundtrack hits harder in surround sound. New game+ with level scaling keeps endgame challenging. CDPR\'s love letter to fans!', '2025-04-21 15:19:10', 16, 'approved'),
(173, 80, 'Viper school gear redesign looks menacing. Roach\'s new hairstyles add whimsy. Russian dub option honors the books\' roots. The best way to experience this timeless epic!', '2025-04-21 15:19:10', 17, 'approved'),
(174, 81, 'Hades II\'s witchcraft mechanics add fresh tactical layers. Nocturnal arms like the Moonstone Axe feel weighty yet precise. Character writing maintains Supergiant\'s signature wit and depth. Early access already feels polished!', '2025-04-21 15:19:10', 1, 'approved'),
(175, 81, 'Incantation system replaces mirror talents with spell-crafting. Resource gathering between runs adds roguelike progression. Melinoë\'s animations ooze personality - especially her sarcastic curtsies!', '2025-04-21 15:19:10', 3, 'approved'),
(176, 81, 'Cross-save between PC and Steam Deck works flawlessly. New foes like the Sirens demand pattern memorization. Voice acting rivals the original\'s excellence. Can\'t wait to see full release!', '2025-04-21 15:19:10', 4, 'approved'),
(177, 81, 'Hexes provide OP builds when combined strategically. The crossroads hub evolves with each story beat. Fishing minigame returns with hilarious Olympian commentary. Another indie masterpiece in the making!', '2025-04-21 15:19:10', 8, 'approved'),
(178, 81, 'Art style pushes 2D animation to new heights. Dynamic music shifts during boss phases elevate tension. Early access roadmap promises exciting updates. Zagreus cameo appearances spark joy!', '2025-04-21 15:19:10', 11, 'approved'),
(179, 82, 'Sea of Thieves: The Legend Returns overhauls naval combat. Harpooning onto enemy ships never gets old. The new cursed cannonballs create chaotic battle scenarios. Fishing tournaments are weirdly therapeutic!', '2025-04-21 15:19:10', 12, 'approved'),
(180, 82, 'Captaincy system lets you name and customize your ship permanently. The Veil quests blend puzzles with epic kraken fights. Cross-alliance betrayal mechanics make every voyage unpredictable. Best played with mic-enabled crews!', '2025-04-21 15:19:10', 13, 'approved'),
(181, 82, 'Plunder Pass rewards feel meaningful without pay-to-win. Ghost Fleet battles are visual spectacles. The Legend of Monkey Island crossover is a hilarious love letter to classics. Endless pirate fantasy!', '2025-04-21 15:19:10', 14, 'approved'),
(182, 82, 'Trident of Dark Tides adds magical combat options. Safer Seas mode lets solo players enjoy stories stress-free. The shanty playlist expansion includes banger sea tunes. Rare\'s perseverance pays off!', '2025-04-21 15:19:10', 15, 'approved'),
(183, 82, 'New ship types like the Brigantine balance speed and firepower. Storm chasing for lightning strikes on enemies is genius. Community events foster server-wide cooperation. The ultimate shared-world adventure!', '2025-04-21 15:19:10', 16, 'approved'),
(184, 83, 'Metroid Prime 4\'s visor scanning rebuilds the world\'s lore organically. Gyro aiming feels precise yet intuitive. Phazon-infused zones distort reality in trippy ways. A triumphant return for Samus!', '2025-04-21 15:19:10', 17, 'approved'),
(185, 83, 'Morph Ball sequences now include momentum-based puzzles. The E.M.M.I. encounters capture Dread\'s tension in 3D. Xeno DNA abilities grant creative traversal options. Retro Studios honors the legacy!', '2025-04-21 15:19:10', 1, 'approved'),
(186, 83, 'HDR makes alien flora glow eerily. Logbook entries narrated by Samus add character depth. Multiplayer modes surprise with creative takes on bounty hunting. The Switch\'s graphical pinnacle!', '2025-04-21 15:19:10', 3, 'approved'),
(187, 83, 'Ridley boss fight reimagined with phase-shifting arenas. Scan pulses reveal hidden pathways in clever ways. Soundtrack remixes classic Metroid motifs with orchestral grandeur. Worth the decade-long wait!', '2025-04-21 15:19:10', 4, 'approved'),
(188, 83, 'Accessibility options include auto-aim scaling for newcomers. Sequence breaking rewards veteran players. The final twist recontextualizes the entire Prime saga. Nintendo\'s sci-fi masterpiece!', '2025-04-21 15:19:10', 8, 'approved'),
(189, 84, 'Animal Crossing: New Horizons 2\'s terraforming tools are revolutionary. Creating multi-tiered waterfalls and zen gardens is meditative. The new villager personalities have deeper dialogue trees. Cloud saves prevent island heartbreak!', '2025-04-21 15:19:10', 11, 'approved'),
(190, 84, 'Cafe expansion lets you brew custom coffee blends. Shooting star showers now include meteor shower variants. The farming system adds crop rotation strategies. Multiplayer minigames finally give visiting purpose!', '2025-04-21 15:19:10', 12, 'approved'),
(191, 84, 'Procedural island generation creates unique starting layouts. NookPhone apps streamline crafting and design mode. The camera tool\'s depth of field options enable magazine-worthy shots. Cozy gaming perfected!', '2025-04-21 15:19:10', 13, 'approved'),
(192, 84, 'Museum curator Blathers finally gets a storyline. Dream suite sharing includes code-based favorites. Seasonal events like cherry blossom festivals are more interactive. Nintendo\'s stress antidote!', '2025-04-21 15:19:10', 14, 'approved'),
(193, 84, 'New sea creatures require diving strategy adjustments. Villager photo requests build meaningful friendships. The inflation-proof bell economy remains charmingly simple. A life simulator masterpiece!', '2025-04-21 15:19:10', 15, 'approved'),
(194, 85, 'Destiny 2: Lightfall\'s Strand subclass revolutionizes mobility. Grappling through Neomuna\'s skyscrapers feels superheroic. The new mod customization allows insane ability spam builds. Root of Nightmares raid puzzles test teamwork!', '2025-04-21 15:19:10', 16, 'approved'),
(195, 85, 'Neomuna patrol zones blend cyberpunk aesthetics with Vex architecture. Cloud striders\' sacrifice storyline hits hard. Weapon crafting lets you create god rolls through focused grinding. Guardian ranks guide new players expertly!', '2025-04-21 15:19:10', 17, 'approved'),
(196, 85, 'Loadout system saves build templates for quick swaps. The new dungeon\'s vertical platforming is deviously fun. Exotic mission rotator brings back Presage-style challenges. Bungie\'s looter-shooter dominance continues!', '2025-04-21 15:19:10', 1, 'approved'),
(197, 85, 'LFG tools in-game reduce reliance on apps. Armor synthesis costs reduced for fashion freedom. The Witness\'s voice acting chills to the bone. Prepare for The Final Shape!', '2025-04-21 15:19:10', 3, 'approved'),
(198, 85, 'Seasonal battlegrounds reuse assets cleverly. Exotic glaives finally feel viable in endgame. Community events like Guardian Games spark friendly competition. Still the best-feeling FPS on market!', '2025-04-21 15:19:10', 4, 'approved'),
(199, 86, 'Star Wars Jedi: Survivor refines lightsaber combat to perfection. The crossguard stance delivers satisfying heavy blows. Koboh\'s open-world exploration rewards curiosity with hidden lore. BD-1\'s new upgrades make traversal puzzles engaging!', '2025-04-21 15:19:10', 8, 'approved'),
(200, 86, 'Performance mode still has frame drops but story compensates. The High Republic-era flashbacks deepen the Jedi Order\'s fall. Customizable saber colors react dynamically to environments. A worthy successor to Fallen Order!', '2025-04-21 15:19:10', 11, 'approved'),
(201, 86, 'New stances like Blaster Jedi blend Force and ranged combat. The Fractured History challenges test mastery of mechanics. Photo mode captures iconic Star Wars vistas perfectly. Respawn nails character-driven storytelling!', '2025-04-21 15:19:10', 12, 'approved'),
(202, 86, 'Caij\'s bounty system adds post-game content depth. The final confrontation with Dagan Gera is lightsaber duel perfection. Hidden chambers reference deep-cut EU lore. Prepare for emotional gut punches!', '2025-04-21 15:19:10', 13, 'approved'),
(203, 86, 'Koboh\'s saloon becomes a lively hub between missions. The Rancor boss fight captures movie-scale terror. New Game+ with red saber crystal is fanservice done right. May the Force be with this franchise!', '2025-04-21 15:19:10', 14, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `description` text NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `release_date`, `description`, `cover_image`, `category_id`, `price`) VALUES
(1, 'Diablo IV', '2023-06-06', 'Diablo IV is the ultimate action RPG experience with endless evil to slaughter, countless abilities to master, nightmarish dungeons, and legendary loot. Embark on the campaign solo or with friends, meeting memorable characters through beautifully dark settings and a gripping story, or explore an expansive end game and shared world where players can trade, team up for world bosses, or descend into PVP zones.', 'diablo4.jpg', 3, 59.99),
(2, 'Civilization VI', '2016-10-20', 'The sixth installment in Sid Meier&rsquo;s Civilization series. Like in all previous Civilization games, the player controls one of eighteen unique historical civilizations, builds its cities, explores the hexagonal map of the world, researches technologies, develops his country&#039;s culture, establishes relationships with other civilizations and wages wars. All the traditional victory types are in place, and a new one, religious, is introduced.\r\n\r\nA distinct new feature in the sixth part is that city improvements are no more concentrated in each city&#039;s only main tile. Instead, they are distributed throughout its whole surrounding area. Each of them is now considered a &quot;district&quot; with a specific purpose, and some of them should be built only on specific terrain. Similarly, wonders now occupy tiles on their own. Technology tree was also modified to take into account the player&#039;s terrain improvements that may speed up the research of certain technologies. Cultural achievements, such as Opera or Drama, are no more considered &quot;technologies&quot; and form a separate Civics research tree instead. Also, unlike most of its predecessors, Civilization VI allows stacking similar types of military units.', '67ea0bcabf3fe.jpg', 6, 29.99),
(3, 'Elden Ring', '2022-02-25', 'THE NEW FANTASY ACTION RPG. Rise, Tarnished, and be guided by grace to brandish the power of the Elden Ring and become an Elden Lord in the Lands Between. A vast world where open fields with a variety of situations and huge dungeons with complex and three-dimensional designs are seamlessly connected. Create your own character and define your playstyle by experimenting with a wide variety of weapons, magical abilities, and skills.', 'elden_ring.jpg', 3, 89.99),
(4, 'The Legend of Zelda: Tears of the Kingdom', '2023-05-12', 'An epic adventure across the land and skies of Hyrule awaits in The Legend of Zelda: Tears of the Kingdom. The sequel to the critically acclaimed Breath of the Wild expands the world vertically - explore floating islands in the skies above Hyrule, as well as the dark depths below. With new abilities like Ultrahand and Fuse, you can create custom weapons, vehicles, and contraptions to solve puzzles and defeat enemies in creative ways.', 'zelda_tears.jpg', 2, 79.99),
(5, 'Starfield', '2023-09-06', 'Starfield is the first new universe in 25 years from Bethesda Game Studios, the creators of The Elder Scrolls V: Skyrim and Fallout 4. In this next generation role-playing game set amongst the stars, create any character you want and explore with unparalleled freedom as you embark on an epic journey to answer humanity\'s greatest mystery. With over 1,000 planets to explore across hundreds of solar systems, you\'ll engage in deep character customization and ship building as you navigate this massive sci-fi RPG.', 'starfield.jpg', 3, 69.99),
(6, 'Baldur\'s Gate III', '2023-08-31', 'Baldur\'s Gate 3 is a story-rich, party-based RPG set in the universe of Dungeons & Dragons, where your choices shape a tale of fellowship and betrayal, survival and sacrifice, and the lure of absolute power. Mysterious abilities are awakening inside you, drawn from a Mind Flayer parasite planted in your brain. Resist, and turn darkness against itself. Or embrace corruption, and become ultimate evil. From the creators of Divinity: Original Sin 2 comes a next-generation RPG set in the world of Dungeons & Dragons.', 'baldurs_gate_3.png', 3, 59.99),
(7, 'Cyberpunk 2077: Phantom Liberty', '2023-09-26', 'Cyberpunk 2077: Phantom Liberty is a spy-thriller expansion for Cyberpunk 2077. Return as cyber-enhanced mercenary V and embark on a high-stakes mission of espionage and intrigue to save the NUS President. Infiltrate the dangerous district of Dogtown and navigate a web of shattered loyalties and political conspiracy. Experience new missions, weapons, cyberware, and vehicles in this ultimate spy-thriller adventure.', 'cyberpunk_phantom.jpg', 1, 39.99),
(8, 'Hogwarts Legacy', '2023-02-10', 'Hogwarts Legacy is an immersive, open-world action RPG set in the world first introduced in the Harry Potter books. Now you can take control of the action and be at the center of your own adventure in the wizarding world. Explore an open world full of magical creatures, customize your character, craft potions, master spell casting, upgrade talents, and become the wizard or witch you want to be. Experience Hogwarts in the 1800s and uncover a hidden truth from your wizarding legacy.', 'hogwarts_legacy.jpg', 2, 59.99),
(9, 'Final Fantasy XVI', '2023-06-22', 'Final Fantasy XVI is the next mainline game in the iconic Final Fantasy series. This thrilling action-RPG takes players on a dark fantasy journey through the land of Valisthea, where mighty Eikons and the Dominants who wield them clash in spectacular battles. Experience a mature, emotionally-charged story of revenge, political intrigue, and the struggle for survival in a world where the very land is dying. Featuring real-time combat directed by Ryota Suzuki (Devil May Cry 5, Dragon\'s Dogma), this is Final Fantasy like you\'ve never seen before.', 'ff16.jpg', 3, 49.99),
(10, 'Spider-Man 2', '2023-10-20', 'Marvel&#039;s Spider-Man 2 is the next chapter in the critically acclaimed Spider-Man series. Play as both Peter Parker and Miles Morales as they team up to take on new threats including the deadly symbiote Venom and the ruthless Kraven the Hunter. Swing through an expanded New York City with new web-swinging mechanics, unlock powerful new abilities, and experience an emotional story about family, responsibility, and what it means to be a hero.', 'spiderman_2.jpg', 1, 69.99),
(11, 'Persona 5', '2016-09-15', 'Persona series is a part of Japanese franchise Megami Tensei and is famous for its anime-like visual style. Persona 5 follows the unnamed main character, a high school student who was falsely accused of assault. He joins the Shujin Academy where he becomes the leading member of Phantom Thieves of Hearts. They are a gang of vigilantes who can to control their Personas and use them in a fight. The Personas are manifestations of people&rsquo;s personalities that look like fictional characters. The Phantom Thieves accompany the main character in his battles as a party.\r\nThe world of Persona consists of two parts. One is the modern Tokyo, in which the main characters live their daily teenagers&rsquo; lives. This is the place for most character interactions, including romancing. The other part is Metaverse, a parallel supernatural world that contains Palaces, which are manifestations of people&rsquo;s malicious thoughts and desires. By day, the main character and his friends attend school and meet friends, and by night, they fight villains in the Metaverse to steal treasures from their Palaces. Battles are turn-based, and characters use a variety of weapons as well as their Personas that provide them with battle magic.', 'p5.jpg', 3, 39.00),
(33, 'Niho 2', '2020-03-13', 'UNLEASH YOUR DARKNESS\r\n\r\nMaster the art of the samurai in this brutal masocore RPG&hellip; for death is coming.\r\n\r\nJourney to 1555 Japan, a country gripped in endless warfare where monsters and evil spirits stalk a land of natural beauty and menacing peril.\r\n\r\nHunt down your enemies as a rogue mercenary wielding the supernatural powers of the mythical Yokai.\r\n\r\nCan you survive the treacherous Sengoku era and the new and terrifying Dark Realm?\r\n\r\n&bull; Discover deadly weapons and skills in a revamped combat system.\r\n&bull; Join friends online in multiplayer modes: summon allies to your aid in Visitors or play completed levels together in Expeditions.', '67e9f001373e0.png', 1, 39.99),
(67, 'God of War: Ragnarök', '2022-11-09', 'Embark on a mythic journey through the Nine Realms as Kratos and Atreus face the impending apocalypse. With visceral combat and stunning visuals, this sequel expands the Norse saga with emotional depth and epic scale.', 'god_of_war_ragnarok.jpg', 1, 69.99),
(68, 'Horizon Forbidden West', '2022-02-18', 'Explore a lush post-apocalyptic world as Aloy, uncovering secrets of ancient machines and battling colossal robotic creatures. This action-RPG combines exploration, strategic combat, and a gripping narrative.', 'horizon_forbidden_west.jpg', 2, 59.99),
(70, 'Stray', '2022-07-19', 'Play as a stray cat navigating a cybercity filled with robots, puzzles, and hidden dangers. This indie gem offers a unique perspective and atmospheric storytelling.', 'stray.jpg', 2, 29.99),
(71, 'Apex Legends: Ignite', '2023-11-01', 'The latest season introduces a new map, reactive legends, and game-changing abilities. Master team-based combat in this fast-paced battle royale.', 'apex_ignite.jpg', 4, 0.00),
(72, 'Total War: Warhammer III', '2022-02-17', 'Command fantastical armies in grand strategy battles across the Chaos realms. Features deep faction customization and epic real-time tactics.', 'total_war_warhammer3.jpg', 6, 59.99),
(73, 'Forza Horizon 5', '2021-11-09', 'Race across vibrant landscapes of Mexico in this open-world driving masterpiece. Customize hundreds of cars and compete in dynamic seasonal events.', 'forza_horizon5.jpg', 15, 59.99),
(76, 'Cities: Skylines II', '2023-10-24', 'Build and manage a metropolis with unprecedented detail. New traffic AI and economic systems challenge even veteran mayors.', 'cities_skylines2.jpg', 7, 49.99),
(77, 'Returnal', '2021-04-30', 'A roguelike shooter where Selene crashes on a shape-shifting alien planet. Die, adapt, and unravel the time-loop mystery in punishing combat.', 'returnal.jpg', 4, 79.99),
(78, 'Monster Hunter Rise: Sunbreak', '2022-06-30', 'Expansion to the acclaimed action-RPG. Hunt new monsters, master the Wirebug, and explore the enigmatic Citadel.', 'mh_rise_sunbreak.jpg', 1, 39.99),
(79, 'Overwatch 2', '2022-10-04', 'Team-based hero shooter with 5v5 battles, new heroes like Kiriko, and dynamic push maps. Free-to-play with seasonal content updates.', 'overwatch2.jpg', 4, 0.00),
(80, 'The Witcher 3: Next-Gen Update', '2022-12-14', 'Enhanced edition of the RPG classic. Ray tracing, faster loading, and new quests enrich Geralt\'s monster-hunting journey.', 'witcher3_nextgen.jpg', 3, 49.99),
(81, 'Hades II', '2024-06-30', 'Roguelike dungeon crawler sequel. Zagreus\' sister Melinoë battles Chronos in Greek underworld with new boons and weapons.', 'hades2.jpg', 1, 29.99),
(82, 'Sea of Thieves: The Legend Returns', '2023-07-20', 'Expansion adding naval warfare upgrades and cursed treasure hunts. Sail with pirates in this shared-world adventure.', 'sea_of_thieves_legend.jpg', 2, 39.99),
(83, 'Metroid Prime 4', '2024-12-31', 'Samus Aran returns in this first-person sci-fi epic. Explore alien worlds and combat cosmic threats with enhanced visor abilities.', 'metroid_prime4.jpg', 1, 59.99),
(84, 'Animal Crossing: New Horizons 2', '2024-03-22', 'Build your dream island paradise with new villagers, crafting recipes, and seasonal events. Cross-play support included.', 'ac_new_horizons2.jpg', 7, 59.99),
(85, 'Destiny 2: Lightfall', '2023-02-28', 'Guardians confront the Witness in Neomuna city. New Strand subclass and raid challenge your mastery of cosmic powers.', 'destiny2_lightfall.jpg', 4, 49.99),
(86, 'Star Wars Jedi: Survivor', '2023-04-28', 'Continue Cal Kestis\' journey in this action-adventure sequel. Explore new planets and refine lightsaber combat styles.', 'jedi_survivor.jpg', 2, 69.99),
(87, 'Battlefield 2042', '2021-11-19', 'The next generation of all-out warfare featuring 128-player battles, dynamic weather events, and cutting-edge weaponry in near-future conflicts. Experience massive-scale destruction across evolving battlefields with full cross-play support.', '682b9d221e61c.jpg', 4, 59.99),
(88, 'Age of Empires IV', '2021-10-28', 'The celebrated RTS franchise returns with 8 diverse civilizations across 4 campaigns spanning 500 years of history. Features stunning 4K visuals, innovative gameplay mechanics, and documentary-style storytelling.', '682b9d4b100f3.jpg', 6, 49.99),
(89, 'Kingdom Come: Deliverance II', '2024-12-31', 'The hardcore historical RPG sequel expands Henry&#039;s journey with improved combat, deeper roleplaying systems, and an even more authentic recreation of 15th century Bohemia. Continue your rise from peasant to knight in this brutally realistic medieval world.', 'kcd2.jpg', 3, 69.99),
(90, 'Total War: Pharaoh', '2023-10-11', 'Command the Bronze Age collapse in this historical strategy epic. Lead Egyptian, Hittite, or Canaanite factions with dynamic campaigns, court politics, and catastrophic natural disasters that reshape the battlefield.', '682b9d641e5e8.jpg', 6, 59.99),
(91, 'Payday 3', '2023-09-21', 'The ultimate co-op heist shooter returns with new tools, tactics, and locations. Plan intricate robberies in dynamic environments that react to your crew&#039;s decisions, whether you go in guns blazing or execute the perfect stealth operation.', '682b9d7b186f8.jpg', 4, 39.99),
(92, 'Company of Heroes 3', '2023-02-23', 'The acclaimed WWII RTS franchise evolves with full tactical pause, destructible environments, and dual campaigns in Italy and North Africa. Command ground, air, and naval forces with unprecedented battlefield control.', '682b9de11afd0.jpg', 6, 59.99),
(93, 'Mount &amp; Blade II: Bannerlord', '2022-10-25', 'Build your empire in this massive medieval sandbox with refined combat, deep diplomacy, and real-time battles featuring hundreds of units. The ultimate fusion of RPG, strategy, and action gameplay.', '682b9db06db7f.jpg', 3, 49.99),
(94, 'Arma 4', '2024-12-31', 'The next evolution in military simulation featuring a new engine, advanced ballistics, and dynamic campaigns. Experience large-scale combined arms warfare with unprecedented realism and modding capabilities.', '682b9b6b2815d.png', 4, 59.99),
(95, 'Jagged Alliance 3', '2023-07-14', 'The beloved tactical mercenary management series returns with turn-based combat, RPG elements, and a sandbox campaign to liberate a fictional country. Hire unique mercs with personalities that clash and bond.', '682b9d3485be9.png', 6, 44.99),
(96, 'Starship Troopers: Extermination', '2023-05-17', '16-player co-op FPS where you join the Mobile Infantry to battle endless Arachnid hordes. Build bases, complete objectives, and survive extraction in large-scale bug hunts inspired by the cult classic films.', '682b9d0592021.jpg', 4, 29.99);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'adminwilliam', 'adminwilliam@rrc.ca', '$2y$10$BZAGwMCHDoT3EH7YwGPguOGwI7kCphntTFHVgd2LvLDIQ1UpLrHn.', 'admin'),
(3, 'nonadminkeke', 'nonadminkeke@rrc.com', '$2y$10$5j6Llv59mWVJ6oq5g6JrVOU3x/H9fdmilI4i0hbZ0k3OcAsV.j32u', 'user'),
(4, 'dionatan', 'dionatan@rrc.ca', '$2y$10$xqCca0eqBg3/Em5xQCwl0OTgSac0eNQLTnMIKyLBX3B58broibjKO', 'user'),
(8, 'ethan', 'ethan@rrc.ca', '$2y$10$oRrdxFUTHiTApbAtv7UkTuVz9fpD.tJsxq.ao3SavyJZ/OBBQ.R5a', 'user'),
(11, 'saansouk', 'saansouk@rrc.ca', '$2y$10$Q1Vs3YSOw23Q9da8TYKI/Obdu9IbPjP1gNYQ6BT0nUb8sxFp6tg0C', 'user'),
(12, 'zhao', 'zhao@rrc.ca', '$2y$10$HBDNp49P0aPtDXfJuS30YumvN4XpVY3QLwYei9WzDMS5gpCwhtvPu', 'user'),
(13, 'qian', 'qian@rrc.com', '$2y$10$IwpuC.rsBIwtVK0VqnJh4eig0TOYTrM6iWrNkBauJYXLnZ.lPexBG', 'user'),
(14, 'sun', 'sun@rrc.ca', '$2y$10$xbRZFb97.f4HFGxK//qT2OwnJlZtbmdESiTpCf2qdq8ga1rG19TOi', 'user'),
(15, 'zhou', 'zhou@rrc.ca', '$2y$10$FL66ddZqbQdatqV5u/gfg.Bbt8dtI7cMytQzlKD2liZwuNGPnL7aK', 'user'),
(16, 'jiang', 'jiang@rrc.ca', '$2y$10$9VK064jbV838/IwoNwrFGenkuCRF9teHvxBIFpeN783YRU65u1PvS', 'user'),
(17, 'yang', 'yang@rrc.ca', '$2y$10$I17ZvRobq9uG40T5024QduI8FCkyJ3oEys7bZxfkDtQk38QCnXrfO', 'user'),
(19, 'bobbob', 'bob@email.com', '$2y$10$c4NRbujzpTpLLNZZGYX7we8EAMcr2LylY35zjZKAduBvoVgT7uPnK', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `fk_comments_user_id` (`user_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
