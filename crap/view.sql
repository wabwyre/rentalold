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
