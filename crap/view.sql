CREATE VIEW service_bills_and_options AS
 SELECT sb.product_id,
    sc.price AS loan_amount
   FROM (revenue_service_bill sb
     LEFT JOIN service_channels sc ON ((sc.service_channel_id = sb.service_channel_id)));