using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class Hauskauf : Table
    {
        public Nullable<int> HauskaufId { get; set; }
        public Nullable<int> TerminId { get; set; }
        public string Kaufpreis { get; set; }
        public string Zahlungsvereinbarung { get; set; }
        public string Anmerkungen { get; set; }
        public string Kaufdatum { get; set; }
        public string Status { get; set; }
        public string Message { get; set; }
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into " + GetTableName() + " (hauskauf_id,termin_id,kaufpreis,zahlungsvereinbarung,anmerkungen,kaufdatum,status,message) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, false);
            query = AddParam(query, row, 2, DataType.STRING, false);
            query = AddParam(query, row, 3, DataType.STRING, false);
            query = AddParam(query, row, 4, DataType.STRING, false);
            query = AddParam(query, row, 5, DataType.DATETIME, false);
            query = AddParam(query, row, 6, DataType.STRING, false);
            query = AddParam(query, row, 7, DataType.STRING, true);

            return query;
        }

        public override string GetTableName()
        {
            return "hauskauf";
        }

        public override string GetPrimaryKeyColumn()
        {
            return "hauskauf_id";
        }
    }
}
