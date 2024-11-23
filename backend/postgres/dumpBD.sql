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

-- Data for user
COPY public."user" (id, email, password, roles, name) FROM stdin;
1   danil@mail.com  0000    ["ROLE_USER"]  \N
2   user@example.com    $2y$13$Z1tnqCYKyZ3BDdwev1wuGOdLsf3WsgSMCzrzMCaOSi/7xO9rkj/sS   ["ROLE_USER"]  \N
3   example@example.com $2y$13$g6ZoTa4z5dJ/L7Q9M7E8cOjDecN8nT.4/r72wDZvZI5DTlsK2hcmS   ["ROLE_USER"]  John Doe
\.

-- Sequence set for user ID
SELECT pg_catalog.setval('public.user_id_seq', 3, true);

-- Primary key for user
ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);

-- Unique index for user email
CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON public."user" USING btree (email);
