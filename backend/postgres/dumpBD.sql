-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

-- Table for user
CREATE TABLE public."user" (
    id integer NOT NULL,
    email character varying(255) DEFAULT NULL::character varying NOT NULL,
    password character varying(255) NOT NULL,
    roles json NOT NULL,
    name character varying(255) DEFAULT NULL::character varying
);

ALTER TABLE public."user" OWNER TO "user";

-- Sequence for user
CREATE SEQUENCE public.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public.user_id_seq OWNER TO "user";

ALTER SEQUENCE public.user_id_seq OWNED BY public."user".id;

-- Default for user ID
ALTER TABLE ONLY public."user" ALTER COLUMN id SET DEFAULT nextval('public.user_id_seq'::regclass);


--
-- Data for Name: country; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.country (id, name) FROM stdin;
\.


--
-- Data for Name: division; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.division (id, title) FROM stdin;
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20241121173717	2024-11-22 23:00:51	36
DoctrineMigrations\\Version20241122224525	2024-11-22 23:00:52	4
DoctrineMigrations\\Version20241123083955	2024-11-23 08:40:46	95
DoctrineMigrations\\Version20241123091209	2024-11-23 11:03:26	120
\.


--
-- Data for Name: event; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.event (id, sport_id, division_id, country_id, region_id, place_id, ekp_id, title, from_date, to_date, amount) FROM stdin;
\.


--
-- Data for Name: event_tag; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.event_tag (event_id, tag_id) FROM stdin;
\.


--
-- Data for Name: place; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.place (id, name) FROM stdin;
\.


--
-- Data for Name: region; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.region (id, name) FROM stdin;
\.


--
-- Data for Name: sport; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.sport (id, title) FROM stdin;
\.


--
-- Data for Name: tag; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.tag (id, value) FROM stdin;
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public."user" (id, email, password, roles, name) FROM stdin;
1   danil@mail.com  0000    ["ROLE_USER"]  \N
2   user@example.com    $2y$13$Z1tnqCYKyZ3BDdwev1wuGOdLsf3WsgSMCzrzMCaOSi/7xO9rkj/sS   ["ROLE_USER"]  \N
3   example@example.com $2y$13$g6ZoTa4z5dJ/L7Q9M7E8cOjDecN8nT.4/r72wDZvZI5DTlsK2hcmS   ["ROLE_USER"]  John Doe
\.


--
-- Name: country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.country_id_seq', 1, false);


--
-- Name: division_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.division_id_seq', 1, false);


--
-- Name: event_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.event_id_seq', 1, false);


--
-- Name: place_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.place_id_seq', 1, false);


--
-- Name: region_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.region_id_seq', 1, false);


--
-- Name: sport_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.sport_id_seq', 1, false);


--
-- Name: tag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.tag_id_seq', 1, false);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.user_id_seq', 3, true);

-- Primary key for user
ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);

-- Unique index for user email
CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON public."user" USING btree (email);
