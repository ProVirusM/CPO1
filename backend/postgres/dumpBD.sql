--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3
-- Dumped by pg_dump version 15.3

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

--
-- Name: country; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.country (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.country OWNER TO "user";

--
-- Name: country_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.country_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.country_id_seq OWNER TO "user";

--
-- Name: country_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.country_id_seq OWNED BY public.country.id;


--
-- Name: division; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.division (
    id integer NOT NULL,
    title character varying(255) NOT NULL
);


ALTER TABLE public.division OWNER TO "user";

--
-- Name: division_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.division_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.division_id_seq OWNER TO "user";

--
-- Name: division_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.division_id_seq OWNED BY public.division.id;


--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO "user";

--
-- Name: event; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.event (
    id integer NOT NULL,
    sport_id integer NOT NULL,
    division_id integer NOT NULL,
    country_id integer NOT NULL,
    region_id integer,
    place_id integer NOT NULL,
    ekp_id integer NOT NULL,
    title character varying(255) NOT NULL,
    from_date date NOT NULL,
    to_date date NOT NULL,
    amount integer NOT NULL
);


ALTER TABLE public.event OWNER TO "user";

--
-- Name: COLUMN event.from_date; Type: COMMENT; Schema: public; Owner: user
--

COMMENT ON COLUMN public.event.from_date IS '(DC2Type:date_immutable)';


--
-- Name: COLUMN event.to_date; Type: COMMENT; Schema: public; Owner: user
--

COMMENT ON COLUMN public.event.to_date IS '(DC2Type:date_immutable)';


--
-- Name: event_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.event_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.event_id_seq OWNER TO "user";

--
-- Name: event_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.event_id_seq OWNED BY public.event.id;


--
-- Name: event_tag; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.event_tag (
    event_id integer NOT NULL,
    tag_id integer NOT NULL
);


ALTER TABLE public.event_tag OWNER TO "user";

--
-- Name: place; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.place (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.place OWNER TO "user";

--
-- Name: place_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.place_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.place_id_seq OWNER TO "user";

--
-- Name: place_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.place_id_seq OWNED BY public.place.id;


--
-- Name: region; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.region (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.region OWNER TO "user";

--
-- Name: region_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.region_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.region_id_seq OWNER TO "user";

--
-- Name: region_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.region_id_seq OWNED BY public.region.id;


--
-- Name: sport; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.sport (
    id integer NOT NULL,
    title character varying(255) NOT NULL
);


ALTER TABLE public.sport OWNER TO "user";

--
-- Name: sport_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.sport_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sport_id_seq OWNER TO "user";

--
-- Name: sport_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.sport_id_seq OWNED BY public.sport.id;


--
-- Name: tag; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.tag (
    id integer NOT NULL,
    value character varying(255) NOT NULL
);


ALTER TABLE public.tag OWNER TO "user";

--
-- Name: tag_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.tag_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tag_id_seq OWNER TO "user";

--
-- Name: tag_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.tag_id_seq OWNED BY public.tag.id;


--
-- Name: user; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public."user" (
    id integer NOT NULL,
    email character varying(255) DEFAULT NULL::character varying NOT NULL,
    password character varying(255) NOT NULL,
    roles json NOT NULL,
    name character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public."user" OWNER TO "user";

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO "user";

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.user_id_seq OWNED BY public."user".id;


--
-- Name: country id; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.country ALTER COLUMN id SET DEFAULT nextval('public.country_id_seq'::regclass);


--
-- Name: division id; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.division ALTER COLUMN id SET DEFAULT nextval('public.division_id_seq'::regclass);


--
-- Name: event id; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.event ALTER COLUMN id SET DEFAULT nextval('public.event_id_seq'::regclass);


--
-- Name: place id; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.place ALTER COLUMN id SET DEFAULT nextval('public.place_id_seq'::regclass);


--
-- Name: region id; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.region ALTER COLUMN id SET DEFAULT nextval('public.region_id_seq'::regclass);


--
-- Name: sport id; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.sport ALTER COLUMN id SET DEFAULT nextval('public.sport_id_seq'::regclass);


--
-- Name: tag id; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.tag ALTER COLUMN id SET DEFAULT nextval('public.tag_id_seq'::regclass);


--
-- Name: user id; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public."user" ALTER COLUMN id SET DEFAULT nextval('public.user_id_seq'::regclass);


--
-- Data for Name: country; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.country (id, name) FROM stdin;
1	USA
\.


--
-- Data for Name: division; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.division (id, title) FROM stdin;
1	Division 1
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
1	1	1	1	1	1	1	Football Championship 2024	2024-05-15	2024-05-15	1
\.


--
-- Data for Name: event_tag; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.event_tag (event_id, tag_id) FROM stdin;
1	1
\.


--
-- Data for Name: place; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.place (id, name) FROM stdin;
1	Кот
\.


--
-- Data for Name: region; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.region (id, name) FROM stdin;
1	USA
\.


--
-- Data for Name: sport; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.sport (id, title) FROM stdin;
1	Football
\.


--
-- Data for Name: tag; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.tag (id, value) FROM stdin;
1	football
2	playoffs
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public."user" (id, email, password, roles, name) FROM stdin;
1	danil@mail.com	0000	["ROLE_USER"]	\N
2	user@example.com	$2y$13$Z1tnqCYKyZ3BDdwev1wuGOdLsf3WsgSMCzrzMCaOSi/7xO9rkj/sS	["ROLE_USER"]	\N
3	example@example.com	$2y$13$g6ZoTa4z5dJ/L7Q9M7E8cOjDecN8nT.4/r72wDZvZI5DTlsK2hcmS	["ROLE_USER"]	John Doe
\.


--
-- Name: country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.country_id_seq', 1, true);


--
-- Name: division_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.division_id_seq', 1, true);


--
-- Name: event_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.event_id_seq', 2, true);


--
-- Name: place_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.place_id_seq', 1, true);


--
-- Name: region_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.region_id_seq', 1, true);


--
-- Name: sport_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.sport_id_seq', 1, true);


--
-- Name: tag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.tag_id_seq', 2, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.user_id_seq', 3, true);


--
-- Name: country country_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.country
    ADD CONSTRAINT country_pkey PRIMARY KEY (id);


--
-- Name: division division_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.division
    ADD CONSTRAINT division_pkey PRIMARY KEY (id);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: event event_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.event
    ADD CONSTRAINT event_pkey PRIMARY KEY (id);


--
-- Name: event_tag event_tag_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.event_tag
    ADD CONSTRAINT event_tag_pkey PRIMARY KEY (event_id, tag_id);


--
-- Name: place place_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.place
    ADD CONSTRAINT place_pkey PRIMARY KEY (id);


--
-- Name: region region_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.region
    ADD CONSTRAINT region_pkey PRIMARY KEY (id);


--
-- Name: sport sport_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.sport
    ADD CONSTRAINT sport_pkey PRIMARY KEY (id);


--
-- Name: tag tag_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.tag
    ADD CONSTRAINT tag_pkey PRIMARY KEY (id);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: idx_1246725071f7e88b; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_1246725071f7e88b ON public.event_tag USING btree (event_id);


--
-- Name: idx_12467250bad26311; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_12467250bad26311 ON public.event_tag USING btree (tag_id);


--
-- Name: idx_3bae0aa741859289; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_3bae0aa741859289 ON public.event USING btree (division_id);


--
-- Name: idx_3bae0aa798260155; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_3bae0aa798260155 ON public.event USING btree (region_id);


--
-- Name: idx_3bae0aa7ac78bcf8; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_3bae0aa7ac78bcf8 ON public.event USING btree (sport_id);


--
-- Name: idx_3bae0aa7da6a219; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_3bae0aa7da6a219 ON public.event USING btree (place_id);


--
-- Name: idx_3bae0aa7f92f3e70; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_3bae0aa7f92f3e70 ON public.event USING btree (country_id);


--
-- Name: uniq_8d93d649e7927c74; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON public."user" USING btree (email);


--
-- Name: event_tag fk_1246725071f7e88b; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.event_tag
    ADD CONSTRAINT fk_1246725071f7e88b FOREIGN KEY (event_id) REFERENCES public.event(id) ON DELETE CASCADE;


--
-- Name: event_tag fk_12467250bad26311; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.event_tag
    ADD CONSTRAINT fk_12467250bad26311 FOREIGN KEY (tag_id) REFERENCES public.tag(id) ON DELETE CASCADE;


--
-- Name: event fk_3bae0aa741859289; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.event
    ADD CONSTRAINT fk_3bae0aa741859289 FOREIGN KEY (division_id) REFERENCES public.division(id);


--
-- Name: event fk_3bae0aa798260155; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.event
    ADD CONSTRAINT fk_3bae0aa798260155 FOREIGN KEY (region_id) REFERENCES public.region(id);


--
-- Name: event fk_3bae0aa7ac78bcf8; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.event
    ADD CONSTRAINT fk_3bae0aa7ac78bcf8 FOREIGN KEY (sport_id) REFERENCES public.sport(id);


--
-- Name: event fk_3bae0aa7da6a219; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.event
    ADD CONSTRAINT fk_3bae0aa7da6a219 FOREIGN KEY (place_id) REFERENCES public.place(id);


--
-- Name: event fk_3bae0aa7f92f3e70; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.event
    ADD CONSTRAINT fk_3bae0aa7f92f3e70 FOREIGN KEY (country_id) REFERENCES public.country(id);


--
-- PostgreSQL database dump complete
--

