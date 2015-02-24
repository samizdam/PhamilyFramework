--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

ALTER TABLE ONLY public.spouse_relationship DROP CONSTRAINT fk_persona_wife;
ALTER TABLE ONLY public.persona DROP CONSTRAINT fk_persona_mother;
ALTER TABLE ONLY public.spouse_relationship DROP CONSTRAINT fk_persona_husband;
ALTER TABLE ONLY public.persona_has_names DROP CONSTRAINT fk_persona_has_names_persona;
ALTER TABLE ONLY public.persona_has_names DROP CONSTRAINT fk_persona_has_names_anthroponym;
ALTER TABLE ONLY public.persona DROP CONSTRAINT fk_persona_gender;
ALTER TABLE ONLY public.persona DROP CONSTRAINT fk_persona_father;
ALTER TABLE ONLY public.anthroponym DROP CONSTRAINT fk_anthroponym_anthroponym_type;
DROP INDEX public.fki_persona_wife;
DROP INDEX public.fki_persona_mother;
DROP INDEX public.fki_persona_husband;
DROP INDEX public.fki_persona_has_names_persona;
DROP INDEX public.fki_persona_has_names_anthroponym;
DROP INDEX public.fki_persona_gender;
DROP INDEX public.fki_persona_father;
DROP INDEX public.fki_anthroponym_anthroponym_type;
ALTER TABLE ONLY public.anthroponym DROP CONSTRAINT uniq_id;
ALTER TABLE ONLY public.gender DROP CONSTRAINT pk_gender;
ALTER TABLE ONLY public.anthroponym_type DROP CONSTRAINT pk_anthroponym_type;
ALTER TABLE ONLY public.anthroponym DROP CONSTRAINT pk_anthroponym;
ALTER TABLE ONLY public.persona DROP CONSTRAINT persona_pkey;
DROP TABLE public.spouse_relationship;
DROP TABLE public.persona_has_names;
DROP TABLE public.persona;
DROP SEQUENCE public.persona_id_increment;
DROP TABLE public.gender;
DROP TABLE public.anthroponym_type;
DROP TABLE public.anthroponym;
DROP SEQUENCE public.anthroponym_id_increment;
DROP EXTENSION plpgsql;
DROP SCHEMA public;
--
-- Name: public; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA public;


--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: anthroponym_id_increment; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE anthroponym_id_increment
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: anthroponym; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE anthroponym (
    id integer DEFAULT nextval('anthroponym_id_increment'::regclass) NOT NULL,
    type character varying(255) NOT NULL,
    value character varying(255) NOT NULL
);


--
-- Name: anthroponym_type; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE anthroponym_type (
    anthroponym_type character varying(255) NOT NULL
);


--
-- Name: gender; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE gender (
    gender character varying(6) NOT NULL
);


--
-- Name: persona_id_increment; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE persona_id_increment
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: persona; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE persona (
    id integer DEFAULT nextval('persona_id_increment'::regclass) NOT NULL,
    "fatherId" integer,
    "motherId" integer,
    gender character varying(6) DEFAULT NULL::character varying,
    "dateOfBirth" bigint,
    "dateOfDeath" bigint,
    "createdAt" timestamp without time zone,
    "updatedAt" timestamp without time zone DEFAULT now() NOT NULL
);


--
-- Name: persona_has_names; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE persona_has_names (
    "personaId" integer NOT NULL,
    "nameId" integer NOT NULL
);


--
-- Name: spouse_relationship; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE spouse_relationship (
    "husbandId" integer NOT NULL,
    "wifeId" integer NOT NULL
);


--
-- Data for Name: anthroponym; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: anthroponym_id_increment; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('anthroponym_id_increment', 18, true);


--
-- Data for Name: anthroponym_type; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: gender; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO gender VALUES ('male');
INSERT INTO gender VALUES ('female');


--
-- Data for Name: persona; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO persona VALUES (170, NULL, NULL, 'male', NULL, NULL, '2015-02-23 22:36:42', '2015-02-23 23:36:42.512608');
INSERT INTO persona VALUES (171, NULL, NULL, 'female', NULL, NULL, '2015-02-23 22:36:42', '2015-02-23 23:36:42.603582');


--
-- Data for Name: persona_has_names; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: persona_id_increment; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('persona_id_increment', 171, true);


--
-- Data for Name: spouse_relationship; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO spouse_relationship VALUES (170, 171);
INSERT INTO spouse_relationship VALUES (170, 171);
INSERT INTO spouse_relationship VALUES (170, 171);


--
-- Name: persona_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT persona_pkey PRIMARY KEY (id);


--
-- Name: pk_anthroponym; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY anthroponym
    ADD CONSTRAINT pk_anthroponym PRIMARY KEY (type, value);


--
-- Name: pk_anthroponym_type; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY anthroponym_type
    ADD CONSTRAINT pk_anthroponym_type PRIMARY KEY (anthroponym_type);


--
-- Name: pk_gender; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY gender
    ADD CONSTRAINT pk_gender PRIMARY KEY (gender);


--
-- Name: uniq_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY anthroponym
    ADD CONSTRAINT uniq_id UNIQUE (id);


--
-- Name: fki_anthroponym_anthroponym_type; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX fki_anthroponym_anthroponym_type ON anthroponym USING btree (type);


--
-- Name: fki_persona_father; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX fki_persona_father ON persona USING btree ("fatherId");


--
-- Name: fki_persona_gender; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX fki_persona_gender ON persona USING btree (gender);


--
-- Name: fki_persona_has_names_anthroponym; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX fki_persona_has_names_anthroponym ON persona_has_names USING btree ("nameId");


--
-- Name: fki_persona_has_names_persona; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX fki_persona_has_names_persona ON persona_has_names USING btree ("personaId");


--
-- Name: fki_persona_husband; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX fki_persona_husband ON spouse_relationship USING btree ("husbandId");


--
-- Name: fki_persona_mother; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX fki_persona_mother ON persona USING btree ("motherId");


--
-- Name: fki_persona_wife; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX fki_persona_wife ON spouse_relationship USING btree ("wifeId");


--
-- Name: fk_anthroponym_anthroponym_type; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY anthroponym
    ADD CONSTRAINT fk_anthroponym_anthroponym_type FOREIGN KEY (type) REFERENCES anthroponym_type(anthroponym_type) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_persona_father; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT fk_persona_father FOREIGN KEY ("fatherId") REFERENCES persona(id);


--
-- Name: fk_persona_gender; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT fk_persona_gender FOREIGN KEY (gender) REFERENCES gender(gender);


--
-- Name: fk_persona_has_names_anthroponym; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY persona_has_names
    ADD CONSTRAINT fk_persona_has_names_anthroponym FOREIGN KEY ("nameId") REFERENCES anthroponym(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_persona_has_names_persona; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY persona_has_names
    ADD CONSTRAINT fk_persona_has_names_persona FOREIGN KEY ("personaId") REFERENCES persona(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_persona_husband; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY spouse_relationship
    ADD CONSTRAINT fk_persona_husband FOREIGN KEY ("husbandId") REFERENCES persona(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_persona_mother; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT fk_persona_mother FOREIGN KEY ("motherId") REFERENCES persona(id);


--
-- Name: fk_persona_wife; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY spouse_relationship
    ADD CONSTRAINT fk_persona_wife FOREIGN KEY ("wifeId") REFERENCES persona(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

