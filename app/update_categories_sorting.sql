UPDATE categories c
SET
    c.sorting = (
        SELECT COUNT(*)
        FROM transactions t
        WHERE
            t.category_id = c.id
        GROUP BY
            t.category_id
    );