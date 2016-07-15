CREATE VIEW service_bills_and_options AS
 SELECT sb.product_id,
    sc.price AS loan_amount
   FROM (revenue_service_bill sb
     LEFT JOIN service_channels sc ON ((sc.service_channel_id = sb.service_channel_id)));


DROP TABLE IF EXISTS revenue_service_bill;

CREATE TABLE public.revenue_service_bill
(
  bill_name character varying(50),
  bill_description character varying(30),
  bill_category character varying(30),
  bill_type character varying(30),
  amount_type character varying(30),
  amount double precision,
  bill_code character varying(30),
  bill_due_time character varying(30),
  revenue_channel_id integer,
  bill_interval character varying(255),
  service_channel_id bigint,
  product_id bigint,
  plot_id bigint,
  revenue_bill_id serial NOT NULL,
  CONSTRAINT revenue_service_bill_pkey PRIMARY KEY (revenue_bill_id)
)
WITH (
  OIDS=FALSE
);

DROP VIEW all_masterfile;
CREATE OR REPLACE VIEW all_masterfile AS
 SELECT m.surname,
    m.active,
    m.mf_id,
    m.firstname,
    m.middlename,
    m.id_passport,
    m.gender,
    m.images_path,
    m.regdate_stamp,
    m.b_role,
    m.dob,
    m.time_stamp,
    m.customer_type_id,
    m.email,
    m.company_name,
    ul.username,
    c.customer_type_name,
    ul.user_role,
    concat(m.surname, ' ', m.firstname, ' ', m.middlename) AS full_name
   FROM masterfile m
     LEFT JOIN user_login2 ul ON ul.mf_id = m.mf_id
     LEFT JOIN customer_types c ON c.customer_type_id = m.customer_type_id;

ALTER TABLE all_masterfile
  OWNER TO postgres;

-- from eric
DROP VIEW contractors_quotes;
CREATE OR REPLACE VIEW contractors_quotes AS
  SELECT q.qoute_id,
    q.bid_amount,
    q.bid_date,
    q.bid_status,
    q.job_status,
    concat(m.surname, ' ', m.firstname, ' ', m.middlename) AS full_name,
    q.maintainance_id,
    mv.maintenance_name
  FROM quotes q
    LEFT JOIN masterfile m ON m.mf_id = q.contractor_mf_id
    LEFT JOIN maintenance_vouchers mv ON mv.voucher_id = q.maintainance_id;
