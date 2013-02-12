--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: evolve_users; Type: TABLE; Schema: public; Owner: krangarajan; Tablespace: 
--

CREATE TABLE evolve_users (
    user_id integer NOT NULL,
    username text
);


ALTER TABLE public.evolve_users OWNER TO krangarajan;

--
-- Name: evolve_users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: krangarajan
--

CREATE SEQUENCE evolve_users_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.evolve_users_user_id_seq OWNER TO krangarajan;

--
-- Name: evolve_users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: krangarajan
--

ALTER SEQUENCE evolve_users_user_id_seq OWNED BY evolve_users.user_id;


--
-- Name: evolve_users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: krangarajan
--

SELECT pg_catalog.setval('evolve_users_user_id_seq', 47, true);


--
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: krangarajan
--

ALTER TABLE ONLY evolve_users ALTER COLUMN user_id SET DEFAULT nextval('evolve_users_user_id_seq'::regclass);


--
-- Data for Name: evolve_users; Type: TABLE DATA; Schema: public; Owner: krangarajan
--

COPY evolve_users (user_id, username) FROM stdin;
10	Akshay
11	Katherine
12	Diana
13	Akshay
14	g
15	krangarajan
16	g
17	krangarajan
18	krangarajan
19	Katherine
20	Katherine
21	Katherine
22	Katherine
23	krangarajan
24	Akshay
25	Diana
26	Katherine
27	krangarajan
28	Diana
29	krangarajan
30	Kavya
31	krangarajan
32	Kavya
33	krangarajan
34	Katherine
35	Diana
36	krangarajan
37	ashwin
38	nik
39	krangarajan
40	Akshay
41	Amod
42	Akshay
43	nik
44	Amod
45	krangarajan
46	krangarajan
47	Amod
\.


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

