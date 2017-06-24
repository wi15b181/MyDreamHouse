using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class HauspaketAttributRegel : Table
    {
        public Nullable<int> RegelId { get; set; }
        public Nullable<int> RegelAttributLeftId { get; set; }
        public Nullable<int> RegelAttributRightId { get; set; }
        public Nullable<double> RegelPreisModifikator { get; set; }
        public string RegelErlaubt { get; set; }
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into " + GetTableName() + " (regel_id,regel_attribut_left_id,regel_attribut_right_id,regel_preis_modifikator,regel_erlaubt) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, false);
            query = AddParam(query, row, 2, DataType.NUMERIC, false);
            query = AddParam(query, row, 3, DataType.NUMERIC, false);
            query = AddParam(query, row, 4, DataType.NUMERIC, true);

            return query;
        }

        public override string GetTableName()
        {
            return "hauspaket_attribut_regel";
        }

        public override string GetPrimaryKeyColumn()
        {
            return "regel_id";
        }
    }
}
