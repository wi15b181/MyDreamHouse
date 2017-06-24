using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class Hersteller : Table
    {
        public Nullable<int> HerstellerId { get; set; }
        public string Name { get; set; }
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into " + GetTableName() + " (hersteller_id,name) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.STRING, true);

            return query;
        }

        public override string GetPrimaryKeyColumn()
        {
            return "hersteller_id";
        }

        public override string GetTableName()
        {
            return "hersteller";
        }
    }
}
